<?php
 namespace App\Services;

    use App\Exceptions\AppError;
    use App\Models\Post;
    use App\Protocols\Repositories\PostRepositoryProtocol;

    class UpdatePostService {

        private $postRepository;

        public function __construct(PostRepositoryProtocol $postRepository)
        {
          $this->postRepository = $postRepository;
        }

        /**
         * @throws AppError
         */
        public function execute($title, $content, $post_id, $user_id):?Post
        {

            if(strlen($content) > 280){
              throw new AppError("content length whit size larger than 280",401);
            }

            $post = $this->postRepository->findById($post_id,$user_id);


            if(!$post){
                throw new AppError("post not found  ",404);
            }

            $post->title = $title;
            $post->content = $content;

            return  $this->postRepository->update($post);
        }

    }
