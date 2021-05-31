<?php

namespace Lamp\Orm\Drivers;

use MongoDB\Client;

/**
 * Class MongoDB
 * @package Lamp\Orm\Drivers
 */
class MongoDB
{

    /**
     * MongoDB 客户端实例
     * @var Client[]
     */
    protected static array $instance = [];

    /**
     * 构造方法
     */
    private function __construct()
    {
        // Not to do somethings.
    }

    /**
     * 获取实例
     * @param string $uri
     * @return Client
     */
    public static function getInstance(string $uri): Client
    {
        if (!isset(self::$instance[$uri])) {
            self::$instance[$uri] = new Client();
        }

        return self::$instance[$uri];
    }

}
