<?php

return [
    
    Floky\Console\Commands\StartApplication::class,

    Floky\Console\Commands\MakeController::class,
    Floky\Console\Commands\MakeMiddleware::class,
    Floky\Console\Commands\MakeRequest::class,
    Floky\Console\Commands\MakeCommand::class,
    Floky\Console\Commands\MakeResource::class,
    Floky\Console\Commands\MakeModel::class,
    Floky\Console\Commands\MakeEntity::class,
    
    Floky\Console\Commands\MakeMigrations::class,
    Floky\Console\Commands\RunMigrations::class,
    Floky\Console\Commands\RebuildMigrations::class,

    Floky\Console\Commands\UpApplication::class,
    Floky\Console\Commands\DownApplication::class,

];