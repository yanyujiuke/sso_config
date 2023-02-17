<?php

namespace App\Tools;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis as FacadesRedis;

class Redis
{
    /**
     * 缓存后台登录用户信息
     */
    const ADMIN_LOGIN_USER = 'admin:login:user';


    /**
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }


    /**
     * @return Connection
     */
    public function getRedis(): Connection
    {
        return FacadesRedis::connection();
    }

    /**
     * redis缓存方法
     * @param string $key
     * @param array|string|null $value
     * @param int $ttl
     * @param string $expire
     * @return bool|mixed
     */
    public function cache(string $key, array|string $value = null, int $ttl = -1, string $expire = 'EX'): mixed
    {
        if (! $key) {
            return true;
        }
        if (is_array($value) && count($value) > 0) {
            $value = json_encode($value);
        }
        $redis = $this->getRedis();
        if ($value) {
            $redis->set($key, $value, $expire, $ttl);
        } else {
            $result = $redis->get($key);
            return json_decode($result, true) ?: $result;
        }
        return true;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function delKey(string $key): mixed
    {
        return $this->getRedis()->del($key);
    }

    /**
     * hash cache
     * @param string $key
     * @param string $field
     * @param string|array|null $value
     * @return bool|mixed
     */
    public function hashCache(string $key, string $field, string|array $value = null): mixed
    {
        if (! $key) {
            return true;
        }
        if (is_array($value) && count($value) > 0) {
            $value = json_encode($value);
        }
        $redis = $this->getRedis();
        if ($value) {
            $redis->hset($key, $field, $value);
        } else {
            $result = $redis->hget($key, $field);
            return json_decode($result, true) ?: $result;
        }
        return true;
    }
}