<?php

namespace App\Http\Middleware;

use App\Api\Common\ApiJson;
use App\Tools\Helper;
use App\Tools\Redis;
use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        $cli_token = $request->header('token');

        // 设置token
        $token = $this->createToken();
        if (!$token) {
            return response(ApiJson::error('Unauthorized',403));
        }

        if ($token != $cli_token) {
            return response(ApiJson::error('Forbidden',401));
        }

        return $next($request);
    }

    public function createToken(): string
    {
        $key = Redis::ADMIN_LOGIN_USER;
        $field = $key . '_' . Helper::getClientIpEx();
        $user = Redis::make()->hashCache($key, $field);
        if (!$user) {
            return '';
        }
        sort($user);
        $str = 'sso';
        foreach ($user as $v) {
            $str .= $v;
        }
        return md5($str);
    }
}
