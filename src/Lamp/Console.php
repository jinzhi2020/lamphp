<?php

namespace Lamp;

use Lamp\Console\Command;
use Lamp\Console\Commands\Helper;
use Lamp\Console\Input;
use LAMP\Console\Output;
use LAMP\Exception\RuntimeException;

/**
 * Class Console
 * @package LAMP
 */
class Console
{

    /**
     * 默认的命令
     * @var array
     */
    private array $defaultCommands = [
        'help' => Helper::class,
    ];

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->loadCommand();
    }

    /**
     * 加载指令
     * @throws RuntimeException
     */
    private function loadCommand()
    {
        $commands = Configs::get('commands', []);
        foreach ($commands as $name => $command) {
            if (get_parent_class($command) !== Command::class) {
                throw new RuntimeException(sprintf('Command %s must extends Command class', $name));
            }
            $this->defaultCommands[$name] = $command;
        }
    }

    /**
     * 运行 CLI 程序
     */
    public function run()
    {
//        $this->configureIO(new Input(), new Output());
        $this->do(new Input(), new Output());
    }

    /**
     * 执行命令
     * @param Input $input
     * @param Output $output
     * @return int
     * @throws RuntimeException
     */
    private function do(Input $input, Output $output): int
    {
        if ($input->hasParameterOptions(['--version', '-V'])) {
            $output->writeln(App::version());
            exit(0);
        }
        // 获取命令的名字
        $name = $this->getCommandName($input);
        if ($input->hasParameterOptions(['--help', '-h'])) {
            // todo: 判断是否显示帮助, 区分名字是否存在
        }
        // 查找并执行命令
        $this->find($name)->run($input, $output);

        return 0;
    }

    /**
     * 获取命令的名字
     * @param Input $input
     * @return string
     */
    private function getCommandName(Input $input): string
    {
        return $input->getFirstArgument();
    }

    /**
     * 查找命令
     * @param string $name
     * @return Command
     * @throws RuntimeException
     */
    private function find(string $name): Command
    {
        if (!isset($this->defaultCommands[$name])) {
            throw new RuntimeException(sprintf('Command %s not found!', $name));
        }
        if (get_parent_class($this->defaultCommands[$name]) !== Command::class) {
            throw new RuntimeException(sprintf('Command %s must extends Command class', $name));
        }

        return new $this->defaultCommands[$name];
    }

    /**
     * 配置基于用户的输入和选项的输入输出实例
     * @access private
     * @param Input $input
     * @param Output $output
     */
    private function configureIO(Input $input, Output $output)
    {

    }
}
