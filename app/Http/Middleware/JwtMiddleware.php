<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class JwtMiddleware extends BaseMiddleware
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {

              if($auth = $request->header('token')) {
                    $request->headers->set('Authorization', $auth);
                }

            try {

                 $user = JWTAuth::parseToken()->authenticate();
                 if($user){
                     $token = $request->header('Authorization' );
                     if($user->active == 0)
                     {
                        $user->update(['google_device_token' => NULL]);
                        JWTAuth::parseToken()->invalidate( $token );
                        return response()->json(['data' => __('lang.user_no_exist'),'status' => 400]);
                    } else {
                        if ($user->authorized_token !== null && $user->authorized_token != str_replace('Bearer ', '', $token)) {
                            JWTAuth::parseToken()->invalidate($token);
                            return response()->json(['data' => __('lang.invalid token'), 'status' => 401], 401);
                        }
                    }
//                    if($user->google_device_token !== $request->header('DeviceToken'))
//                    {
//                        $token = $request->header('Authorization' );
//                        JWTAuth::parseToken()->invalidate( $token );
//                        return response()->json(['data' => __('lang.Wrong Device Token'),'status' => 400]);
//                    }
                 }

            } catch (Exception $e) {

                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['data' => __('lang.invalid token'),'status' => 401]);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['data' => __('lang.token expired'),'status' => 400]);
                }else{

                    return response()->json(['data' => __('lang.token absent'),'status' => 400]);
                }
            }
            return $next($request);
        }
    }
