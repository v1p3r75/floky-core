<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;


#[AsCommand(
    name: 'make:controller',
    description: 'Create a new controller',
)]
class MakeController extends Command
{

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $output->writeln('Hello');

        return Command::SUCCESS;
    }
}