<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AppError;
use App\Repositories\EloquentPostRepository;
use App\Services\CreatePostService;
use App\Services\DeletePostService;
use App\Services\EditPostService;
use App\Services\ListPostsService;
use App\Services\UpdatePostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{

    public function index(): JsonResponse
    {
        $listPosts = new ListPostsService(new EloquentPostRepository());

        $posts = $listPosts->execute();

        return response()->json($posts, 200)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    public function create(Request $request): JsonResponse

    {
        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');
        $title = $request->input("title");
        $content = $request->input("content");

        $createPost = new CreatePostService(
            new EloquentPostRepository()
        );
        //if theres no image
        $img_url = null;
        $file = null;
        $fileName = null;


        //generating file name
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = Uuid::uuid4() . $file->getClientOriginalName();
            $img_url = "https://parlador-ideal.s3.amazonaws.com/post/image/" . $fileName;
        }

        try {

            $post = $createPost->execute($title, $content, $user_id, $img_url);

            //if theres  image just store
            $file ? $file->storeAs("/post/image/", $fileName, "s3") : null;

            return response()->json(["post" => $post], 201)->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }
    }

    public function edit(Request $request)
    {
        $editPost = new EditPostService(new EloquentPostRepository());

        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');
        try {

            $post_id = $request->route()->parameter("id");
            $post = $editPost->execute($post_id, $user_id);

            return response()->json($post)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }

    }

    public function update(Request $request)
    {

        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');
        $post_id = $request->route()->parameter("id");


        $title = $request->input("title");
        $content = $request->input("content");

        $editPost = new UpdatePostService(new EloquentPostRepository());

        try {

            $post = $editPost->execute($title, $content, $post_id, $user_id);

            return response()->json($post, 200)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }

    }

    public function delete(Request $request)

    {

        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');
        $post_id = $request->route()->parameter("id");

        $deletePostService = new DeletePostService(new EloquentPostRepository());

        try {

            $deletePostService->execute($post_id, $user_id);

            return response()->json([], 204)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }


    }
}
