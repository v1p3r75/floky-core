<?php

namespace Floky\Console;

use Floky\Facades\Config;
use Symfony\Component\Console\Application as ConsoleApplication;

class Console extends ConsoleApplication
{
    private array $coreKernel = [];

    public function __construct($name = 'Floky Console', $version = '1.0.0')
    {
        parent::__construct($name, $version);
        $this->coreKernel = require_once __DIR__ . './Kernel.php';
    }

    public function saveCommands(array $kernel): self
    {

        $commands = array_merge($this->coreKernel, $kernel);
        $commands = array_map(fn ($command) => new $command, $commands);
        $this->addCommands($commands);

        return $this;
    }
}