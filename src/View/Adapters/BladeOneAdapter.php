<?php

namespace Floky\View\Adapters;

use eftec\bladeone\BladeOne;
use Exception;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;
use Floky\View\ViewInterface;

class BladeOneAdapter implements ViewInterface
{

    private string $cache_path;

    public function __construct(private BladeOne $engine) {

        $this->engine->setMode($this->engine::MODE_DEBUG);
    }

    public function setPath(string $path) {

        return $this->engine->setPath($path, $this->cache_path);
   }

   public function setCachePath(string $path) {

        return $this->cache_path = $path;
    }

   public function setExtension(string $extension) {

        return $this->engine->setFileExtension('.php');
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