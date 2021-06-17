<?php


namespace App\Http\Controllers\Api;

use App\Exceptions\AppError;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\HashServiceProvider;
use App\Repositories\EloquentUserRepository;
use App\Services\CreateUserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{

    public function show()
    {
        return User::all();
    }


    public function create(Request $request ) :JsonResponse
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $password = $request->input("password");

        $createUser = new CreateUserService(
            new EloquentUserRepository(),
            new HashServiceProvider()
        );

        try {
            $user =  $createUser->execute($name,$email,$password);
            return response()->json(["user"=>$user],201);

        }  catch (AppError $e) {
            return response()->json(["error"=>$e->message],$e->code);
        }

    }
}
