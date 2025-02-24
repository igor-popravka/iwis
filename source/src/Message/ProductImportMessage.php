<?php

namespace App\Message;

final class ProductImportMessage
{
     public function __construct(
         public readonly string $name,
         public readonly float $price,
         public readonly string $category,
     ) {
     }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
