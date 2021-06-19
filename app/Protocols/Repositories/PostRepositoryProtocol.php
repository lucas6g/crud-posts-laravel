<?php
namespace App\Protocols\Repositories;

use App\Models\Post;

interface PostRepositoryProtocol{

    function create($title,$content,$user_id,$img_url):Post;
    function all():iterable;
    function findById($post_id,$user_id):?Post;
    function  update(Post $post):?Post;
    function delete(Post $post):void;
    function  findAll($user_id):iterable;


}
