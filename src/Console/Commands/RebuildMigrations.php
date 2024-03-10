<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'rebuild:migrations',
    description: 'Delete and restart all migrations from scratch',
)]
class RebuildMigrations extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->getNexa()->rebuildAllMigrations();

        return true;

    }
}