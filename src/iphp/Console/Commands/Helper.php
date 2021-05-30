<?php

namespace iphp\Console\Commands;

use iphp\Console\Command;
use iphp\Console\Input;
use iphp\Console\Output;
use iphp\Exception\RuntimeException;

/**
 * Class Helper
 * @package iphp\Console\Commands
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
