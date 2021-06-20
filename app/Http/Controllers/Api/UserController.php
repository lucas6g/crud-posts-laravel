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
use Illuminate\Support\Facades\Input;


class UserController extends Controller

{

    /**
     * @OA\Post(
     * path="/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
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
