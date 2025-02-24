<?php

namespace App\MessageHandler;

use App\Message\ProductImportMessage;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Entity\Mongo\Product;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ProductImportMessageHandler
{
    public function __construct(
        private readonly DocumentManager $dm,
    ) {
    }

    public function __invoke(ProductImportMessage $message): void
    {
        $product = (new Product())
            ->setName($message->getName())
            ->setPrice($message->getPrice())
            ->setCategory($message->getCategory())
            ->setCreatedAt((new \DateTime()));

        $this->dm->persist($product);
        $this->dm->flush();
    }
}
