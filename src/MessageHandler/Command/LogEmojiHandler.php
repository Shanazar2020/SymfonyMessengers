<?php

namespace App\MessageHandler\Command;

use App\Message\Command\LogEmoji;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogEmojiHandler implements MessageHandlerInterface
{

    private static $emojis = [
        '👻',
        '🤡',
        '🤖',
        '🎃',
        '😱',
        '👾',
        '👽',
    ];
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function __invoke(LogEmoji $logEmoji)
    {
        $index = $logEmoji->getEmojiIndex();
        $emoji = self::$emojis[$index] ?? self::$emojis[0];

        $this->logger->info('Important Message: ' . $emoji);
    }

}