<?php

namespace Floky\View;

class View 
{

    public function __construct(private ViewInterface $engine, bool $isFrameworkView = false) {

        $path = $isFrameworkView ? app_storage_path("framework") : app_view_path();

        if ($isFrameworkView)
            $this->engine->setExtension('.php');

        $this->engine->setPath($path);
        $this->engine->setCachePath(app_cache_path());

    }

/**
     * Render a view
     * @param string $view
     * @param array $data
     */
    public function render(string $view, array $data = []): string
    {

        return $this->engine->render($view, $data);
    
    }
}