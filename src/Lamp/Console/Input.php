<?php

namespace Lamp\Console;

use Lamp\Console\Input\Argument;
use Lamp\Console\Input\Definition;
use Lamp\Console\Input\Option;

/**
 * Class Input
 * @package Lamp\Console
 */
class Input
{

    /**
     * 参数
     * @var Argument[]
     */
    private array $arguments;

    /**
     * 选项
     * @var Argument[]
     */
    private array $options;

    /**
     * 定义
     * @var Definition
     */
    private Definition $definition;

    /**
     * 命令选项
     * @var array
     */
    private array $tokens;

    /**
     * 交互模式
     * @var bool
     */
    private bool $interactive = true;

    /**
     * 解析后的参数
     * @var array
     */
    private array $parsed;

    /**
     * Input constructor.
     */
    public function __construct()
    {
        $argv = $_SERVER['argv'];
        // 去除命令入口文件
        array_shift($argv);
        $this->tokens = $argv;
    }

    /**
     * 检查原始参数是否包含指定的多个值
     * @param array $values
     * @return bool
     */
    public function hasParameterOptions(array $values): bool
    {
        foreach ($values as $value) {
            if ($this->hasParameterOption($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检查原始参数是否包含指定的值
     * @param string $value
     * @return bool
     */
    public function hasParameterOption(string $value): bool
    {
        foreach ($this->tokens as $token) {
            if ($token === $value || str_contains($token, $value . '=')) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取应用的第一个参数
     */
    public function getFirstArgument(): string
    {
        foreach ($this->tokens as $token) {
            // 跳过 php console -option command 中 -option 这样的参数
            if ($token && str_starts_with($token, '-')) {
                continue;
            }
            return $token;
        }

        return '';
    }

    /**
     * 绑定参数
     */
    public function bind(Definition $definition)
    {
        $this->arguments = [];
        $this->options = [];
        $this->definition = $definition;

        $this->parse();
    }

    /**
     * 解析参数
     */
    private function parse()
    {
        $this->parsed = $this->tokens;
        while (null !== $token = array_shift($this->parsed)) {
            if (str_starts_with($token, '--')) {
                $this->parseLongOption($token);
            } elseif (str_starts_with($token, '-') && '-' != $token) {
                $this->parseShortOption($token);
            } else {
                $this->parseArgument($token);
            }
        }
    }

    /**
     * 解析长选项
     * @param string $token
     */
    private function parseLongOption(string $token)
    {
        $name = substr($token, 2);
        $pos = strpos($name, '=');
        if ($pos !== false) {
            $key = substr($name, 0, $pos);    // 例如 key=value, key
            $value = substr($name, $pos + 1);   // 例如 key=value, value
            $this->addLongOption($key, $value);
        } else {
            $this->addLongOption($name, null);
        }
    }

    /**
     * 解析短选项
     * @param string $token
     */
    private function parseShortOption(string $token)
    {
    }

    /**
     * 解析参数
     * @param mixed $token
     */
    private function parseArgument(string $token)
    {
    }

    /**
     * 添加长参数
     * @param string $key
     * @param string $value
     */
    private function addLongOption(string $key, string $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * 获取参数
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
