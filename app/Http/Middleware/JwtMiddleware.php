<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/1/19
 * Time: 00:52
 */

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JwtMiddleware extends BaseMiddleware
{
    public function __construct(\Tymon\JWTAuth\JWTAuth $auth)
    {
        parent::__construct($auth);
    }

    public function handle($request, Closure $next)
    {
        $accessToken = JWTAuth::parseToken();
        try
        {
            $accessToken->authenticate();
        }
        catch (Exception $e)
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json(['status' => 'Token is Invalid']);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json(['status' => 'Token is Expired']);
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException)
            {
                return response()->json(['status'=> $e->getMessage()]);
            }else if ($e instanceof  \Tymon\JWTAuth\Exceptions\TokenBlacklistedException)
            {
                return response()->json(['status'=> 'token has been blacklisted']);
            }else
            {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
