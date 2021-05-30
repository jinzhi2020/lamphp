<?php

namespace iphp\Console;

use iphp\Console\Input\Definition;
use RuntimeException;

/**
 * Class Command
 * @package iphp\Console
 */
class Command
{
    protected Input $input;

    protected Output $output;

    /**
     * 参数定义
     * @var Definition
     */
    protected Definition $definition;

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->definition = new Definition();
        $this->configure();
    }

    /**
     * 配置指令
     */
    protected function configure()
    {

    }

    /**
     * 执行命令
     */
    public function run(Input $input, Output $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->input->bind($this->definition);
    }

    /**
     * 验证命令名称
     * @param string $name
     * @throws RuntimeException
     */
    protected function validateName(string $name): void
    {
        // 使用正则: /^[^\:]++(\:[^\:]++)*$/, 不能以 : 开头不能包含连续的 ::
        if (!preg_match('/^[^\:]++(\:[^\:]++)*$/', $name)) {
            throw new RuntimeException(sprintf("Command name %s is invalid", $name));
        }
        // PHP8 使用如下做法
//        return !((str_starts_with($name, ':') || str_contains($name, '::')));
    }

    public function handle()
    {

    }

    /**
     * 执行命令
     * @param Input $input
     * @param Output $output
     * @return false|mixed
     */
    protected function execute(Input $input, Output $output)
    {
        return call_user_func([$this, 'handle']);
    }
}
