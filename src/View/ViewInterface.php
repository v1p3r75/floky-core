<?php

namespace Floky\View;

interface ViewInterface 
{
    
    public function setPath(string $path, string $cache_path);

    public function setExtension(string $extension);

    public function render(string $view, array $data = []);

}