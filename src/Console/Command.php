<?php

namespace Floky\Console;

use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

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
}