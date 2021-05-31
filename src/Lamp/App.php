<?php

namespace Lamp;

use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Class App
 * @package Lamp
 */
class App
{

    /**
     * 框架版本
     */
    private const VERSION = '0.1';

    /**
     * 默认时区
     * @var string
     */
    private const DEFAULT_TIMEZONE = 'Asia/Shanghai';

    /**
     * 初始化目录
     */
    private const INIT_DIR = [
        'App',
        'App/Http',
        'App/Http/Controller',
        'Configs',
        'Runtime',
        'Runtime/Cache',
        'Runtime/Log',
    ];

    /**
     * 获取 Console 实例
     * @return Console
     * @throws Exception
     */
    public static function getConsole(): Console
    {
        self::init();
        return new Console();
    }

    /**
     * 应用初始化
     * @throws Exception
     */
    public static function init(): void
    {
        // 加载配置
        Configs::load();
        // 设置时区
        self::setTimeZone();
        // 初始化目录结构
        self::initDir();
    }

    /**
     * 设定时区
     * @throws Exception
     */
    private static function setTimeZone(): void
    {
        $timezone = Configs::get('timezone', self::DEFAULT_TIMEZONE);
        // 检查时区是否正确
        $timezones = timezone_identifiers_list();
        if (!in_array($timezone, $timezones)) {
            throw new Exception('Time zone not supported!');
        }

        date_default_timezone_set($timezone);
    }

    /**
     * 初始化目录结构
     */
    private static function initDir(): void
    {
        foreach (self::INIT_DIR as $dir) {
            !is_dir($dir) && mkdir($dir);
        }
    }

    /**
     * 返回框架版本
     * @return string
     */
    public static function version(): string
    {
        return 'version: ' . static::VERSION;
    }

    /**
     * @throws ReflectionException
     */
    public static function run(string $module, string $controller, string $action)
    {
        // 执行应用
        $class = "App\\Http\\Controller\\$module\\$controller";
        if (!class_exists($class)) {
            throw new Exception('Controller not found!');
        }
        $controller = new $class;
        if (self::hasRequestParameter($controller, $action)) {
            $response = (new $class)->$action(new Request());
        } else {
            $response = (new $class)->$action();
        }
        if (is_string($response)) {
            header('Content-Type:text/html');
            echo $response;
        } else if (is_array($response)) {
            header('Content-Type:application/json');
            echo json_encode($response);
        } else if (is_null($response)) {
            header('Content-Type::text/html');
            exit(0);
        }
    }

    /**
     * 返回是否存在 request 参数
     * @param object $controller
     * @param string $action
     * @return bool
     * @throws ReflectionException
     */
    private static function hasRequestParameter(object $controller, string $action): bool
    {
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod($action);
        $parameters = $method->getParameters();
        $hasRequestParameter = false;
        foreach ($parameters as $parameter) {
            if ($parameter->getType()->getName() === Request::class) {
                $hasRequestParameter = true;
                break;
            }
        }

        return $hasRequestParameter;
    }
}
