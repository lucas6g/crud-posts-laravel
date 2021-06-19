<?php

namespace Tests\Unit\Fakes\Repositories;

use App\Models\Post;
use App\Protocols\Repositories\PostRepositoryProtocol;

class FakePostRepository implements PostRepositoryProtocol
{
    private $posts = [];


    public function create($title, $content, $user_id, $img_url): Post
    {
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = $user_id;
        $post->img_url = $img_url;

        array_push($this->posts, $post);

        return $post;
    }

    public function all(): iterable
    {

        return $this->posts;
    }


    public function findById($post_id, $user_id): ?Post
    {
        $post = null;
        foreach ($this->posts as $post) {
            if ($post->id === $post_id && $post->user_id === $user_id) {
                $post = $post;
            }
        }

        return $post;
    }

    public function update(Post $post): ?Post
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            if ($this->posts[$i]->id === $post->id) {
                $this->posts[$i] = $post;
            }
        }

        return $post;

    }

    public function delete(Post $post): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            if ($this->posts[$i]->id === $post->id) {
                unset($this->posts[$i]);
            }
        }

    }


}

