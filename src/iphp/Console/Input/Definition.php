<?php

namespace iphp\Console\Input;

/**
 * Class Definition
 * @package iphp\Console\Input
 */
class Definition
{
    /**
     * 参数
     * @var Argument[]
     */
    private array $arguments;

    /**
     * 选项
     * @var Option[]
     */
    private array $options;

    /**
     * 构造方法
     * @param array $definition
     */
    public function __construct(array $definition = [])
    {
        $this->setDefinitions($definition);
    }

    /**
     * 设置选项或参数的定义
     * @param array $definition
     */
    private function setDefinitions(array $definition)
    {
        $options = $arguments = [];
        foreach ($definition as $item) {
            if ($item instanceof Option) {
                $options[] = $item;
            } else {
                $arguments = $item;
            }
        }
        $this->setOptions($options);
        $this->setArguments($arguments);
    }

    /**
     * 设置选项
     * @param Option[] $options
     */
    private function setOptions(array $options)
    {
        foreach ($options as $option) {
            $this->options[$option->getName()] = $option;
        }
    }

    /**
     * 设置参数
     * @param Argument[] $arguments
     */
    private function setArguments(array $arguments)
    {
        foreach ($arguments as $argument) {
            $this->arguments[$argument->getName()] = $argument;
        }
    }
}
