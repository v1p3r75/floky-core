<?php

namespace Floky\Facades;

use eftec\bladeone\BladeOne;
use Exception;
use Floky\Exceptions\Code;
use Floky\Exceptions\NotFoundException;

class View extends Facades
{

    private ?BladeOne $engine = null;

    public function __construct(bool $isForFrameworkView = false)
    {
        $path = $isForFrameworkView ? app_storage_path("framework") : app_view_path();

        $this->engine = new BladeOne($path, app_cache_path(), BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.

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