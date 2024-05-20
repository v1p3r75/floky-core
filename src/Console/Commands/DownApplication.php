<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Floky\Config\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'down',
    description: 'Down the application',
)]
class DownApplication extends Command
{

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $envFile = dirname($this->app->getAppDirectory()) . "/.env";

        $content = @file_get_contents($envFile);

        if(! $content) {

            $output->writeln("<error>Environment file '.env' not found !</error>");
            return Command::FAILURE;
        }

        $content = str_replace(Command::APP_UP, Command::APP_DOWN, $content);

        file_put_contents($envFile, $content);

        $output->writeln("<info>Application down sucessfully !</info>");
        return Command::SUCCESS;
      
    }
}