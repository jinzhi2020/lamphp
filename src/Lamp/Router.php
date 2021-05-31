<?php
declare(strict_types=1);

namespace Lamp;

use Exception;

/**
 * Class Router
 * @package Lamp
 */
class Router
{
    /**
     * 路由中的模块
     * @var string
     */
    protected static string $module = '';

    /**
     * 路由中的控制器
     * @var string
     */
    protected static string $controller = '';

    /**
     * 路由中的方法
     * @var string
     */
    protected static string $action = '';

    /**
     * 路由分发
     */
    public static function dispatch(): array
    {
        $routeString = $_GET['s'] ?? null;
        if (is_null($routeString)) {
            throw new Exception('Route not found!');
        }
        // 路由参数 unset
        unset($_GET['s']);

        $routeParams = explode('/', substr($routeString, 1, strlen($routeString)));
        [self::$module, self::$controller, self::$action] = $routeParams;

        return $routeParams;
    }

    /**
     * 获取模块
     * @return string
     */
    public static function getModule(): string
    {
        return self::$module;
    }

    /**
     * 获取控制器
     * @return string
     */
    public static function getController(): string
    {
        return self::$controller;
    }

    /**
     * 获取操作
     * @return string
     */
    public static function getAction(): string
    {
        return self::$action;
    }
}
