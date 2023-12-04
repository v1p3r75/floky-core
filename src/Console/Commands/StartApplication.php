<?php

namespace Floky\Console\Commands;

use Floky\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'serve',
    description: 'Start a local server',
)]
class StartApplication extends Command
{

    protected function configure()
    {

        $this
        ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'The name of the command', 8080);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $phpBinary = (new PhpExecutableFinder)->find();

        if(! $phpBinary) {

            $output->writeLn('PHP executable not found. Please add it to the PATH environment variable and try again.');
            return Command::FAILURE;
        }

        $port = $input->getOption('port');
        $script = dirname(app_root_path()) . '/server.php';

        $process = new Process([$phpBinary, '-S', "localhost:{$port}", $script]);
        $process->setTimeout(null);
        $output->writeln("\n<info>Starting ...</info>\n");
        $process->run(function ($type, $buffer) use ($output): void {
            $output->writeln("<info>$buffer</info>");
        });
        
        return Command::SUCCESS;
      
    }
}