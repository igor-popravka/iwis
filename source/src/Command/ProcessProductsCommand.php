<?php

namespace App\Command;

use App\Entity\MySql\Category;
use App\Entity\MySql\Product;
use App\Entity\Mongo\Product AS MongoProduct;
use App\Repository\Mongo\ProductRepository as MongoProductRepository;
use App\Repository\MySql\CategoryRepository as MySqlCategoryRepository;
use App\Repository\MySql\ProductRepository as MySqlProductRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:process-products',
    description: 'Process products',
)]
class ProcessProductsCommand extends Command
{
    public function __construct(
        private readonly MongoProductRepository $mongoProductRepository,
        private readonly MySqlProductRepository $mysqlProductRepository,
        private readonly MySqlCategoryRepository $mysqlCategoryRepository,
        private readonly EntityManagerInterface $em,
        private readonly DocumentManager $dm,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $mongoProducts = $this->mongoProductRepository->findBy(['status' => 'new']);

        foreach ($mongoProducts as $mongoProduct) {
            try {
                $this->em->getConnection()->beginTransaction();

                if(
                    !($mysqlCategory = $this->mysqlCategoryRepository->findOneBy(
                        ['name' => $mongoProduct->getCategory()]
                    ))
                    || !($mysqlProduct = $this->mysqlProductRepository->findOneBy(
                        ['name' => $mongoProduct->getName(), 'category_id' => $mysqlCategory->getId()]
                    ))
                ) {
                    $mysqlCategory = $mysqlCategory ?? new Category();
                    $mysqlProduct = new Product();
                }

                $mysqlCategory->setName($mongoProduct->getCategory());

                $this->em->persist($mysqlCategory);
                $this->em->flush();

                $mysqlProduct
                    ->setName($mongoProduct->getName())
                    ->setPrice($mongoProduct->getPrice())
                    ->setCategoryId($mysqlCategory->getId());

                $this->em->persist($mysqlProduct);
                $this->em->flush();

                $mongoProduct->setStatus(MongoProduct::STATUS_PROCESSED);

                $this->dm->persist($mongoProduct);
                $this->dm->flush();

                $this->em->getConnection()->commit();

            } catch (\Throwable $throwable) {
                $this->em->getConnection()->rollBack();

                throw $throwable;
            }
        }

        return Command::SUCCESS;
    }
}
