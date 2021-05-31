<?php

namespace Lamp;

/**
 * Class Facade
 * @package Lamp
 */
class Facade
{

    /**
     * 调用实际的类
     * @param string $name
     * @param array $arguments
     * @return false|mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return call_user_func([self::createFacade(), $name], ...$arguments);
    }

    /**
     * 创建门面类实例
     */
    protected static function createFacade()
    {
        $className = static::getFacadeClass();

        return (new $className);
    }

    /**
     * 获取门面类
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return '';
    }
}
