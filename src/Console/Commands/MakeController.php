<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller')
        ->addOption('resource', 'r', InputOption::VALUE_NONE, 'Make resource controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $name = $input->getArgument('name');     
        $isResource = $input->getOption('resource');
        $path = app_controllers_path( $name . '.php');

        if ($isResource) {

            return $this->make($output, $name, $path, 'controller-resource.make');
        }

        return $this->make($output, $name, $path, 'controller.make');
    }
}