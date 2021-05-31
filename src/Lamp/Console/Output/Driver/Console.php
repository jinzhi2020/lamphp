<?php

namespace LAMP\Console\Output\Driver;

use Lamp\Console\Output;
use Lamp\Console\Output\Formatter;

/**
 * Class Console
 * @package Lamp\Console\Output\Driver
 */
class Console
{
    /**
     * 基本输出流
     * @var Resource
     */
    private $stdout;

    /**
     * 输出类
     * @var Output
     */
    private Output $output;

    /**
     * 格式化类
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * 构造方法
     * @param Output $output
     */
    public function __construct(Output $output)
    {
        $this->output = $output;
        $this->stdout = $this->openOutputStream();
        $this->formatter = new Formatter();
    }

    /**
     * 打开基本输出流
     */
    private function openOutputStream()
    {
        return fopen('php://stdout', 'w');
    }

    /**
     * 输出消息
     * @param string $message
     * @param bool $newline
     */
    public function write(string $message, bool $newline = false)
    {
        $newline = $newline ? PHP_EOL : '';
        // 转换样式
        $message = $this->formatter->format($message);
        @fwrite($this->stdout, $message . $newline);
        fflush($this->stdout);
    }
}