<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'make:controller',
    description: 'Create a new controller',
)]
class MakeController extends Command
{

    protected function configure()
    {

        $this
        ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $name = $input->getArgument('name');        
        $path = app_controllers_path( $name . '.php');
        $stub = $this->getStub('controller.make', ['name' => $name]);

        if( file_exists($path)) {

            $output->writeln("<error>This File already exists</error>");
            return Command::FAILURE;
        }

        if (! file_put_contents($path, $stub)) {

            $output->writeln("<error>An error occurred while creating the file</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info> Filed created : [$path]</info>");
        return Command::SUCCESS;
    }
}