<?php

namespace Floky\View\Adapters;

use eftec\bladeone\BladeOne;
use Exception;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Floky\View\ViewInterface;

class BladeOneAdapter implements ViewInterface
{

    public function __construct(private BladeOne $engine) {

        $this->engine->setMode($this->engine::MODE_DEBUG);
    }

    public function setPath(string $path, string $cache_path) {

        $this->engine->setPath($path, $cache_path);
   }


   public function setExtension(string $extension) {

        $this->engine->setFileExtension('.php');
   }


    /**
     * Render a view
     * @param string $view
     * @param array $data
     * @throws NotFoundException
     */
    public function render(string $view, array $data = []): string
    {

        try {
            
            return $this->engine->run($view, $data);

        } catch(Exception $e) {

            throw new NotFoundException($e->getMessage(), Code::FILE_NOT_FOUND);
        }
    }
}