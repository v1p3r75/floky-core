<?php

namespace Floky\View;

interface ViewInterface 
{
    
    public function setPath(string $path);

    public function setCachePath(string $path);

    public function setExtension(string $extension);

    public function render(string $view, array $data = []);

}