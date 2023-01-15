<?php

namespace App\ServiceModels;

use App\Services\RedisService;

class Redis
{

    public static function setCache(string $name, string $data): void
    {
        RedisService::getService()->set($name, $data);
    }

    public static function getCache($name): string|null
    {
        return RedisService::getService()->get($name);
    }

    public static function flushAllData() {
        
        return RedisService::getService()->flushall();
    }
}