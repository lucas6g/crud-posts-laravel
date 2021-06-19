<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EloquentPostRepository;
use App\Services\ListUserPostsService;
use Illuminate\Http\JsonResponse;


class ListUserPostsController extends Controller
{

    public function index(): JsonResponse
    {

        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');


        $listPosts = new ListUserPostsService(new EloquentPostRepository());

        $posts = $listPosts->execute($user_id);

        return response()->json($posts, 200)->setEncodingOptions(JSON_UNESCAPED_SLASHES);


    }
}
