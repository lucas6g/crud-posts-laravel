<?php
    namespace App\Http\Middleware;

    use Illuminate\Http\Request;

    use Tymon\JWTAuth\Exceptions\JWTException;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
    use Closure;
    use Tymon\JWTAuth\Facades\JWTAuth;


    //midleware for handle jwt validation

    class RequireAuth extends BaseMiddleware {
        public function handle(Request $request,Closure $next){
            try {
            JWTAuth::parseToken()->authenticate();

            } catch (JWTException $exception) {
                return response()->json(['error' => "you most be login"],400);
            }
            return $next($request);

        }
    }
