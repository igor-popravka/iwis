<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ProductSavedEvent extends Event
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
