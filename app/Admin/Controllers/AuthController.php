<?php

namespace App\Admin\Controllers;

use App\Tools\Helper;
use App\Tools\Redis;
use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;

class AuthController extends BaseAuthController
{
    public function postLogin(Request $request)
    {
        $parent = parent::postLogin($request);

        // 缓存后台登录用户信息
        $username = $request->input('username');
        $client_id = Helper::getClientIpEx();
        $key = Redis::ADMIN_LOGIN_USER;
        $field = $key . '_' . $client_id;
        Redis::make()->hashCache($key, $field, [
            'username' => $username,
            'password' => $request->input('password'),
            'client_ip' => $client_id,
            'time' => time()
        ]);

        return $parent;
    }

    public function getLogout(Request $request)
    {
        $parent = parent::getLogout($request);

        // 退出登录，删除用户缓存信息
        Redis::make()->delKey(Redis::ADMIN_LOGIN_USER);

        return $parent;
    }
}
