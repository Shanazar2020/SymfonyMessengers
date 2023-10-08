<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Message\DeletePhotoFile;
use App\Photo\PhotoFileManager;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $imagePostRepository;
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, EntityManagerInterface $entityManager, ImagePostRepository $imagePostRepository)
    {
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->messageBus = $messageBus;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePostId = $deleteImagePost->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);
        $filename = $imagePost->getFilename();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->messageBus->dispatch(new DeletePhotoFile($filename));
    }

}