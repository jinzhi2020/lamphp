<?php

namespace Lamp\Console;

use Lamp\Console\Output\Driver\Console;

/**
 * Class Output
 * @package Lamp\Console
 *
 * @see Console::setDecorated
 * @method void setDecorated($decorated)
 */
class Output
{
    /**
     * @var Console
     */
    private Console $handle;

    /**
     * 构造方法
     */
    public function __construct()
    {
        // xxx: 相互依赖
        $this->handle = new Console($this);
    }

    /**
     * 输出消息并换行
     * @param string $message
     */
    public function writeln(string $message)
    {
        $this->write($message, true);
    }

    /**
     * 输出消息
     * @param string $message
     * @param bool $newline
     */
    private function write(string $message, bool $newline = false)
    {
        $this->handle->write($message, $newline);
    }

    /**
     * 动态方法调用
     * @param $method
     * @param $args
     * @return void|mixed
     */
    public function __call($method, $args)
    {
        if ($this->handle && method_exists($this->handle, $method)) {
            return call_user_func_array([$this->handle, $method], $args);
        }
    }
}
