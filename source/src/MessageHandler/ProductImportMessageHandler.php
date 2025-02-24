<?php

namespace App\MessageHandler;

use App\Message\ProductImportMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ProductImportMessageHandler
{
    public function __invoke(ProductImportMessage $message): void
    {
        // do something with your message
    }
}
