<?php
 namespace App\Http\Controllers\Api;

 use App\Providers\JwtTokenServiceProvider;
 use App\Repositories\EloquentUserRepository;
 use Illuminate\Http\Request;
 use Illuminate\Http\JsonResponse;
 use App\Http\Controllers\Controller;
 use App\Services\AuthenticateUserService;
 use App\Exceptions\AppError;


 class AuthController extends Controller
 {
     /**
      * Get a JWT via given credentials.
      *
      * @return JsonResponse
      */
     public function login(Request $request): JsonResponse
     {
         $email = $request->input("email");
         $password = $request->input("password");

         $authenticateUser = new AuthenticateUserService(
             new EloquentUserRepository(),
             new JwtTokenServiceProvider()
         );
         try {
             $userWhitToken = $authenticateUser->execute($email,$password);

             return response()->json($userWhitToken,200);
         }  catch (AppError $e) {
             return response()->json(["error"=>$e->message],$e->code);
         }
     }

 }
