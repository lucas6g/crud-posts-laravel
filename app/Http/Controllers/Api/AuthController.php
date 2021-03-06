<?php

namespace App\Http\Controllers\Api;

use App\Providers\JwtTokenServiceProvider;
use App\Repositories\EloquentUserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\AuthenticateUserService;
use App\Exceptions\AppError;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $authenticateUser = new AuthenticateUserService(
            new EloquentUserRepository(),
            new JwtTokenServiceProvider()
        );
        try {
            $userWhitToken = $authenticateUser->execute($validatedData['email'], $validatedData['password']);

            return response()->json($userWhitToken, 200);
        } catch (AppError $e) {
            return response()->json(["error" => $e->message], $e->code);
        }
    }

}
