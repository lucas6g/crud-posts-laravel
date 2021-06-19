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

            return response()->json(["user" => $user], 201);

        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }

    }
}
