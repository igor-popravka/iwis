<?php

namespace App\Message\Serializer;


use App\Message\ProductImportMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessageSerializerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductImportJsonSerializer implements MessageSerializerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $message = $this->serializer->deserialize(
            data: $encodedEnvelope['body'] ?? null,
            type: ProductImportMessage::class,
            format: 'json'
        );

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if (!$message instanceof ProductImportMessage) {
            throw new \Exception('Unsupported message class');
        }

        return [
            'body' => $this->serializer->serialize($message, 'json'),
        ];
    }
}
