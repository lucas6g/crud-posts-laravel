<?php


namespace App\Http\Controllers\Api;

use App\Exceptions\AppError;
use App\Http\Controllers\Controller;
use App\Providers\HashServiceProvider;
use App\Repositories\EloquentUserRepository;
use App\Services\CreateUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller

{

    /**
     *
     *
     * @OA\Post(path="api/user",
     *   tags={"user"},
     *   summary="Create user",
     *   description="This can only be done by any user",
     *   @OA\RequestBody(
     *       required=true,
     *      @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="name",type="string"),
     *      @OA\Property(property="email",type="string"),
     *      @OA\Property(property="password",type="string"),
     *      )
     *   ),
     *    @OA\Response(
     *     response="201",
     *      description="Succsses",
     *     @OA\MediaType(mediaType="application/json",
     *
     *    @OA\Examples(
     *        summary="created user",
     *        example = "created user",
     *       value = {
     *              "name": "string",
     *              "email": "string",
     *             "id" : "integer",
     *              "created_at":"date",
     *              "updated_at":"date"
     *         },
     *      )
     * ),
     *
     * ),
     *
     * )
     */
    public function create(Request $request): JsonResponse
    {


        //validating request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $createUser = new CreateUserService(
            new EloquentUserRepository(),
            new HashServiceProvider()
        );

        try {
            $user = $createUser->execute($validatedData['name'], $validatedData['email'], $validatedData['password']);

            return response()->json($user, 201);
        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }
    }
}
