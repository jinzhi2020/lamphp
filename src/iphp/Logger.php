<?php

namespace iphp;

use DateTimeZone;
use iphp\Logger\Handlers\StreamHandler;
use Monolog\Logger as MonoLogger;

/**
 * Class Logger
 * @package iphp
 */
class Logger
{

    /**
     * 默认的日志通道
     */
    private const DEFAULT_CHANNEL = 'default';

    /**
     * 日志默认的时区
     */
    private const DEFAULT_TIMEZONE = 'Asia/Shanghai';

    /**
     * 日志 Channel 实例
     * @var array['Channel' => MogoLogger]
     */
    private static array $instances = [];

    /**
     * Logger constructor.
     * @param string $dir
     * @param string|null $name
     * @param array $handlers
     * @param array $processors
     * @param DateTimeZone|null $timezone
     * @return MonoLogger
     */
    public static function getInstance(string $dir, ?string $name = null, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null): MonoLogger
    {
        $name ??= self::DEFAULT_CHANNEL;
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new MonoLogger(
                $name,
                empty($handlers) ? self::getDefaultHandlers($dir) : $handlers,
                $processors,
                $timezone ?? self::getTimezone()
            );
        }

        return self::$instances[$name];
    }

    /**
     * 获取默认的 Handlers
     * @param string $dir
     * @return array
     */
    private static function getDefaultHandlers(string $dir): array
    {
        return [StreamHandler::create($dir)];
    }

    /**
     * 获取配置中的时区
     * @return DateTimeZone
     */
    private static function getTimezone(): DateTimeZone
    {
        $timezone = Configs::get('timezone', self::DEFAULT_TIMEZONE);

        return new DateTimeZone($timezone);
    }
}
