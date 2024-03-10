<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'run:migrations',
    description: 'Execute all migrations',
)]
class RunMigrations extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        return $this->getNexa()->runAllMigrations();

    }
}