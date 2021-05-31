<?php
declare(strict_types=1);

namespace Lamp;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Configs
 * @package LAMP
 */
class Configs
{

    /**
     * 配置
     * @var array
     */
    private static array $configs = [];

    /**
     * 环境变量
     * @var array
     */
    private static array $env = [];

    /**
     * 加载配置
     */
    public static function load(string $dir)
    {
        self::loadEnv($dir);
        self::$configs = array_merge(self::$configs, include $dir . 'Configs/app.php');
    }

    /**
     * 加载环境变量
     */
    private static function loadEnv(string $dir)
    {
        $envFilepath = $dir . '.env';
        // 如果存在环境变量文件并且文件内容不为空，则加载配置文件
        if (is_file($envFilepath) && !empty(file_get_contents($envFilepath))) {
            self::$env = Yaml::parseFile($envFilepath);
        }
    }

    /**
     * 获取环境变量
     * @param string $key
     * @param $defaultValue
     * @return mixed
     * @example static::env('key')
     * @example static::env('parent.key')
     */
    public static function env(string $key, $defaultValue = null)
    {
        // 支持 . 语法，Yaml 最多支持 2 级
        if (str_contains($key, '.')) {
            [$first, $second] = explode('.', $key);
            return self::$env[$first][$second] ?? $defaultValue;
        }

        return self::$env[$key] ?? $defaultValue;
    }

    /**
     * 获取配置
     * @param string $key
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public static function get(string $key, $defaultValue = null)
    {
        return self::$configs[$key] ?? $defaultValue;
    }
}
