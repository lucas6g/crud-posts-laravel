<?php
namespace App\Services;


use App\Exceptions\AppError;

use App\Protocols\Repositories\PostRepositoryProtocol;

class DeletePostService{
    private $postRepository;

    public function __construct(PostRepositoryProtocol $postRepository)

    {
        $this->postRepository = $postRepository;
    }

    /**
     * @throws AppError
     */
    public function execute($post_id,$user_id)
    {
        $post = $this->postRepository->findById($post_id,$user_id);

        if(!$post){
            throw new AppError("post not found",404);
        }

        $this->postRepository->delete($post);

    }

}
