<?php

namespace Floky\Console;

use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Output\Output;

class Command extends SymfonyCommand 
{

    public function getStub(string $name, $params = [])
    {
        $path = __DIR__ . '/Stubs/' . $name . '.stub';

        if(! file_exists($path)) {

            throw new NotFoundException('Could not find a stub file', Code::FILE_NOT_FOUND);
        }

        $stubContent = file_get_contents($path);
        $stub = "";

        foreach($params as $search => $replace)
        {
            $stub = str_replace("{{{$search}}}", $replace, $stubContent);
        }

        return $stub;
    }

    public function make(
        Output $output, string $name,
        string $file, string $stub,
        ?array $options = null
    ): int
    {

        $stub = $this->getStub($stub, $options ?? ['name' => $name]);

        if( file_exists($file)) {

            $output->writeln("<error>This File already exists</error>");
            return Command::FAILURE;
        }

        if (! file_put_contents($file, $stub)) {

            $output->writeln("<error>An error occurred while creating the file</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info> Filed created : [$file]</info>");
        return Command::SUCCESS;
    }
}