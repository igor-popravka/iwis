<?php

namespace App\Repository\Mongo;

use App\Entity\Mongo\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * @extends DocumentRepository<Product>
 */
class ProductRepository extends DocumentRepository
{
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct(
            $documentManager,
            $documentManager->getUnitOfWork(),
            $documentManager->getClassMetadata(Product::class)
        );
    }
}
