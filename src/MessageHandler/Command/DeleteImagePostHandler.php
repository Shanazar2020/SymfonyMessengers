<?php

namespace App\MessageHandler\Command;

use App\Message\Command\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageSubscriberInterface
{
    private $entityManager;
    private $imagePostRepository;
    private $eventBus;

    public function __construct(MessageBusInterface $eventBus, EntityManagerInterface $entityManager, ImagePostRepository $imagePostRepository)
    {
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke($deleteImagePost)
    {
        $imagePostId = $deleteImagePost->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);
        $filename = $imagePost->getFilename();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new ImagePostDeletedEvent($filename));
    }

    public static function getHandledMessages(): iterable
    {
         yield DeleteImagePost::class => [
             'method' => '__invoke',
             'priority' => 10,
//             'from_transport' => 'async'
         ];
    }


}