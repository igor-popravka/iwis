<?php

namespace App\Entity\Mongo;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'products')]
#[ODM\HasLifecycleCallbacks]
#[ODM\Index(keys: ["status" => "asc"], name: "status_index")]
class Product
{
    const STATUS_NEW = 'new';
    const STATUS_PROCESSED = 'processed';

    #[ODM\Id]
    private string $id;
    #[ODM\Field]
    private string $name;
    #[ODM\Field(type: 'float')]
    private float $price;
    #[ODM\Field]
    private string $category;
    #[ODM\Field]
    private string $status = self::STATUS_NEW;
    #[ODM\Field(type: 'date')]
    private \DateTimeInterface $created_at;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
