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
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *
     *     path="/api/post",
     *      tags={"post"},
     *     summary="Get all posts",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *     response="200",
     *      description="Succsses",

     *
     *   )
     * )
     */

    public function index(): JsonResponse
    {
        $listPosts = new ListPostsService(new EloquentPostRepository());

        $posts = $listPosts->execute();

        return response()->json($posts, 200)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }


    /**
     *
     * @OA\Post(path="api/post",
     *   tags={"post"},
     *   summary="Create post",
     *   description="This can only be done by any authenticated users",
     *
     *   @OA\RequestBody(
     *       required=true,
     *      @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="title",type="string"),
     *      @OA\Property(property="content",type="string"),
     *      )
     *   ),
     *    @OA\Response(
     *     response="201",
     *      description="Succsses",
     *     @OA\MediaType(mediaType="application/json",
     *
     *
     * ),
     *
     * ),
     *
     * )
     */
    public function create(Request $request): JsonResponse

    {
        //getting the authenticated user id
        $payload = auth("api")->payload();
        $user_id = $payload->get('sub');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

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

            $post = $createPost->execute($validatedData['title'], $validatedData['content'], $user_id, $img_url);

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


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $editPost = new UpdatePostService(new EloquentPostRepository());

        try {

            $post = $editPost->execute($validatedData['title'], $validatedData['content'], $post_id, $user_id);

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
