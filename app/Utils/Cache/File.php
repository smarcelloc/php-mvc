<?php

namespace App\Utils\Cache;

use Closure;

class File
{
    public static function getCache(string $hash, int $expiration, Closure $callback)
    {
        if ($content = self::getContentCache($hash, $expiration)) {
            return $content;
        }

        $content = $callback();
        self::storageCache($hash, $content);

        return $content;
    }

    private static function storageCache(string $hash, mixed $content)
    {
        $serializeContent = serialize($content);
        $filename = self::getFilePath($hash);

        return file_put_contents($filename, $serializeContent);
    }

    private static function getFilePath(string $hash)
    {
        if (!file_exists(CACHE_DIR)) {
            mkdir(CACHE_DIR, 0755, true);
        }

        return CACHE_DIR . '/' . $hash;
    }

    private static function getContentCache(string $hash, int $expiration)
    {
        $cacheFile = self::getFilePath($hash);
        if (!file_exists($cacheFile)) return false;

        $createTimeCache = filectime($cacheFile);
        $diffTime = time() - $createTimeCache;
        if ($diffTime > $expiration) return false;

        $serializeContent = file_get_contents($cacheFile);
        return unserialize($serializeContent);
    }
}
