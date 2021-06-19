<?php

namespace App\Services;


use App\Exceptions\AppError;
use App\Models\Post;
use App\Protocols\Repositories\PostRepositoryProtocol;

class CreatePostService
{

    private $postRepository;

    public function __construct(PostRepositoryProtocol $postRepository)

    {
        $this->postRepository = $postRepository;
    }

    /**
     * @throws AppError
     */
    public function execute($title, $content, $img_url, $user_id): Post
    {

        if (strlen($content) > 280) {
            throw  new AppError("content length whit size larger than 280");
        }

        $post = $this->postRepository->create($title, $content, $img_url, $user_id);

        return $post;

    }

}
