<?php
declare(strict_types=1);

namespace Lamp;

use Doctrine\Common\Cache\Cache as ICache;
use Lamp\Cache\Drives\FileSystemCache;
use Lamp\Exception\ConfigNotFound;
use Lamp\Exception\RuntimeException;

/**
 * Class Cache
 * @package Lamp
 */
class Cache
{

    /**
     * 缓存适配器
     * @var ICache|null
     */
    protected static ?ICache $adapter = null;

    /**
     * 内置的缓存实现
     * @var array|string[]
     */
    protected static array $adapterMap = [
        'file' => FileSystemCache::class,
    ];

    /**
     * 获取缓存，如果不存在则执行回调
     * @param string $id
     * @param callable $func
     * @param int $expire
     * @return mixed
     * @throws ConfigNotFound
     * @throws RuntimeException
     */
    public static function remember(string $id, callable $func, int $expire = 60): mixed
    {
        if (self::getAdapter()->contains($id)) {
            return self::getAdapter()->fetch($id);
        }
        $data = $func();
        self::getAdapter()->save($id, $data, $expire);

        return $data;
    }

    /**
     * 获取适配器
     * @return ICache
     * @throws RuntimeException
     * @throws ConfigNotFound
     */
    public static function getAdapter(): ICache
    {
        if (is_null(self::$adapter)) {
            $configs = self::getConfigs();
            $className = self::$adapterMap[strtolower($configs['drive'])] ?? $configs['impl'] ?? null;
            if (!in_array(ICache::class, class_implements($className))) {
                throw new RuntimeException('Cache not implement cache interface!');
            }
            self::$adapter = new $className($configs['dir'] ?? '/');
        }

        return self::$adapter;
    }

    /**
     * 获取缓存配置
     * @return array
     * @throws ConfigNotFound
     */
    private static function getConfigs(): array
    {
        $configs = Configs::get('cache', []);
        if (!isset($configs['drive'])) {
            throw new ConfigNotFound();
        }

        return $configs;
    }
}