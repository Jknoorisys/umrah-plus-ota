<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        $token  = null;

        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $token = $matches[1];
        }

        if (is_null($header) && is_null($token)) {
            return response()->json(
                [
                    'status'       =>  "failed",
                    'message'      =>  trans('msg.jwt.TokenNotSet'),
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        
        try {
            $user                  =  JWTAuth::parseToken()->getPayload();
            $request->uuid         =  $user['uuid'];

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json(
                    [
                        'status'       =>  "failed",
                        'message'      =>  trans('msg.jwt.InvalidToken'),
                    ],
                    Response::HTTP_UNAUTHORIZED
                );

            } elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json(
                    [
                        'status'       =>  "failed",
                        'message'      =>  trans('msg.jwt.expiredToken'),
                    ],
                    Response::HTTP_UNAUTHORIZED
                );

            } else {
                return response()->json(
                    [
                        'status'       =>  "failed",
                        'message'      =>  trans('msg.jwt.TokenNotFound'),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        return $next($request);
    }
}