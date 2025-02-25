<?php

namespace App\Listener;

use App\Event\ProductSavedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class ProductSavedEventListener
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(ProductSavedEvent $event): void
    {
        $this->logger->info($event->getMessage());
    }
}
