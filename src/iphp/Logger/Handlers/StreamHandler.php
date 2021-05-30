<?php

namespace iphp\Logger\Handlers;

use Monolog\Handler\StreamHandler as MogoStreamHandler;

/**
 * Class StreamHandler
 * @package iphp\Logger\Handlers
 */
class StreamHandler
{

    /**
     * 日志默认的存储路径
     * @var string
     */
    private const DEFAULT_FILE_PATH = '/Runtime/Logs/';

    /**
     * 默认的文件名格式
     * @var string
     */
    private const DEFAULT_FILE_NAME_FORMAT = '%s-%s-%s.log';

    /**
     * 创建 StreamHandler
     * @param string $dir
     * @return MogoStreamHandler
     */
    public static function create(string $dir): MogoStreamHandler
    {
        return new MogoStreamHandler(self::getLogFilepath($dir));
    }

    /**
     * 获取日志的文件路径
     * @param string $dir
     * @return string
     */
    private static function getLogFilepath(string $dir): string
    {
        return self::DEFAULT_FILE_PATH .
            sprintf(self::DEFAULT_FILE_NAME_FORMAT,
                date('Y'),
                date('m'),
                date('d')
            );
    }

}
