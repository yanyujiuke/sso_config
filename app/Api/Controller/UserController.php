<?php

namespace App\Api\Controller;

use App\Api\BaseController;
use App\Api\Common\ApiJson;
use App\Tools\Helper;
use App\Tools\Redis;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    /**
     * 获取后台登录用户信息接口
     * @return JsonResponse
     */
    public function getLoginUser(): JsonResponse
    {
        $key = Redis::ADMIN_LOGIN_USER;
        $field = $key . '_' . Helper::getClientIpEx();
        $user = Redis::make()->hashCache($key, $field);
        if (!$user) {
            $user = [];
        }
        return ApiJson::success($user);
    }
}