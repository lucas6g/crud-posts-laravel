<?php
    namespace App\Services;

    use App\Protocols\Repositories\PostRepositoryProtocol;

    class ListPostsService {

        private $postRepository;

        public function __construct(PostRepositoryProtocol $postRepository)
        {
            $this->postRepository  = $postRepository;
        }

        public function execute(): iterable
        {
            return $this->postRepository->all();

        }

    }
