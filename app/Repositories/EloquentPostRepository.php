<?php

namespace App\Repositories;

use App\Models\Post;

use App\Protocols\Repositories\PostRepositoryProtocol;


class EloquentPostRepository implements PostRepositoryProtocol
{

    public function create($title, $content, $user_id, $img_url): Post
    {
        $post = new Post();

        $post->title = $title;
        $post->content = $content;
        $post->img_url = $img_url;
        $post->user_id = $user_id;

        $post->save();

        return $post;
    }

    public function all(): iterable
    {
        return Post::with('user')->get();

    }

    public function findById($post_id, $user_id): ?Post
    {
        return Post::where('id', $post_id)
            ->where(function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->get()->first();
    }

    public function update(Post $post): Post
    {
        $post->save();

        return $post;

    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function findAll($user_id): iterable
    {
        return Post::where('user_id', $user_id)->get();
    }
}

