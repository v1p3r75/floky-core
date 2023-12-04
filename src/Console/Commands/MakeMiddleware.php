<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:middleware',
    description: 'Create a new middleware',
)]
class MakeMiddleware extends Command
{

    protected function configure()
    {

        $this
        ->addArgument('name', InputArgument::REQUIRED, 'The name of the middleware');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $name = $input->getArgument('name');        
        $path = app_middlewares_path( $name . '.php');

        return $this->make($output, $name, $path, 'middleware.make');

    }
}