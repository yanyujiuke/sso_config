<?php

namespace App\Tools;

use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * 获取客户端IP地址
     *
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @return mixed
     */
    public static function getClientIpEx(int $type = 0): mixed
    {
        static $ip = null;
        if ($ip !== null) {
            return $ip[$type];
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if ($pos !== false) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['X-Real-IP'])) {
            $ip = $_SERVER['X-Real-IP'];
        }
        // IP地址合法验证
        $long = false;
        if ($ip) {
            $long = sprintf('%u', ip2long($ip));
        }
        $ip = $long ? [
            $ip,
            $long,
        ] : [
            '0.0.0.0',
            0,
        ];
        return $ip[$type];
    }

    public static function getImageURL($path): string
    {
        if (!$path) {
            return '';
        }
        $preg = "/^http[s]?:\/\//i";
        if (preg_match($preg, $path)) {
            return $path;
        } else {
            return Storage::disk('s3')->url($path);
        }
    }
}