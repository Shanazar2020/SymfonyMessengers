<?php

namespace App\Messenger;

use App\Message\Command\LogEmoji;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);
        $message = new LogEmoji($data['emoji']);

        return new Envelope($message);
    }

    public function encode(Envelope $envelope): array
    {
        /** @var LogEmoji $message */
        $message = $envelope->getMessage();
        $body = [
            'emoji' => $message->getEmojiIndex()
        ];

        return [
            'body' => json_encode($body),
            'header' => ''
        ];
    }
}