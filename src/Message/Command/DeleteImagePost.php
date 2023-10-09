<?php

namespace App\Message\Command;

class DeleteImagePost
{
    private $imagePostId;

    public function __construct(int $imagePostId)
    {

        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }
}