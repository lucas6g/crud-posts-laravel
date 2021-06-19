<?php

namespace App\Services;

use App\Protocols\Repositories\PostRepositoryProtocol;

class ListUserPostsService
{

    private $postRepository;

    public function __construct(PostRepositoryProtocol $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute($user_id): iterable
    {
        return $this->postRepository->findAll($user_id);

    }

}
