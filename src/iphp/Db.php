<?php

namespace iphp;

use Exception;
use MysqliDb;

class Db
{

    /**
     * 默认配置
     * @var array
     */
    private const DEFAULT_CONFIGS = [
        'host' => 'localhsot',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'db' => 'Tests',
    ];

    /**
     * 数据库链接实例
     * @var MysqliDb|null
     */
    private static ?MysqliDb $instance = null;

    /**
     * 获取数据库实例
     * @return MysqliDb|null
     * @throws Exception
     */
    public static function getInstance(): ?MysqliDb
    {
        if (is_null(self::$instance)) {
            $configs = self::getConfigs();
            self::$instance = new MysqliDb(
                $configs['host'], $configs['user'], $configs['password'],
                $configs['db'], $configs['port'], $configs['charset']
            );
        }

        return self::$instance;
    }

    /**
     * 获取配置
     * @return array
     * @throws Exception
     */
    private static function getConfigs(): array
    {
        $configs = Configs::get('mysql');
        if (is_null($configs) || !is_array($configs)) {
            throw new Exception('MySQL Configs undefined!');
        }

        return array_merge(self::DEFAULT_CONFIGS, $configs);
    }
}
