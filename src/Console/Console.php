<?php

namespace Floky\Console;

use Floky\Application;
use Floky\Facades\Config;
use Symfony\Component\Console\Application as ConsoleApplication;

class Console extends ConsoleApplication
{

    private string $consoleName = 'Floky Console';

    private string $consoleVersion = '1.0.0';

    public Application $app;


    private array $coreKernel = [];

    public function __construct(string $root_dir)
    {

        parent::__construct($this->consoleName, $this->consoleVersion);

        $this->app = Application::getInstance($root_dir, true);
        require dirname(__DIR__) . "./Helpers.php";

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