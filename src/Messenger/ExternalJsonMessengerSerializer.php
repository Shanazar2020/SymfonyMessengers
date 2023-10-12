<?php

namespace App\Messenger;

use App\Message\Command\LogEmoji;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);

        if (null === $data){
            throw new MessageDecodingFailedException('Invalid JSON');
        }

        if (!isset($data['emoji'])){
            throw new MessageDecodingFailedException('No emoji key');
        }

        if (!isset($headers['type'])){
            throw new MessageDecodingFailedException('No type set');
        }

        switch ($headers['type']){
            case 'emoji':
                return $this->createLogEmojiEnvelope($data);
        }

        throw new MessageDecodingFailedException(sprintf('Invalid type %s', $headers['type']));
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

    public function createLogEmojiEnvelope(array $emoji): Envelope
    {
        $message = new LogEmoji($emoji['emoji']);

        $envelope = new Envelope($message);

        $envelope = $envelope->with(new BusNameStamp('command.bus'));
        return $envelope;
    }
}