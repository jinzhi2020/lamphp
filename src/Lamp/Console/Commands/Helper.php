<?php

namespace Lamp\Console\Commands;

use Lamp\Console\Command;
use Lamp\Console\Input;
use Lamp\Console\Output;
use Lamp\Exception\RuntimeException;

/**
 * Class Helper
 * @package Lamp\Console\Commands
 */
class Helper extends Command
{

    /**
     * @inheritDoc
     * @throws RuntimeException
     */
    public function configure()
    {
        $this->setName('help');
    }

    /**
     * 执行命令
     * @param Input $input
     * @param Output $output
     */
    public function run(Input $input, Output $output)
    {
        $output->writeln('Help info!');
    }
}
