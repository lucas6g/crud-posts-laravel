<?php
    namespace App\Services;


    use App\Exceptions\AppError;
    use App\Models\Post;
    use App\Protocols\Repositories\PostRepositoryProtocol;

    class EditPostService{
        private $postRepository;

        public function __construct(PostRepositoryProtocol $postRepository)

        {
            $this->postRepository = $postRepository;
        }

        /**
         * @throws AppError
         */
        public function execute($post_id,$user_id):?Post
        {
            $post = $this->postRepository->findById($post_id,$user_id);

            if(!$post){
                throw new AppError("post not found",404);
            }

          return  $post;

        }

    }
