<?php

namespace Floky\Facades;

use eftec\bladeone\BladeOne;
use Exception;

class View extends Facades
{

    private ?BladeOne $engine = null;

    public function __construct(bool $isForFrameworkView = false)
    {
        $path = $isForFrameworkView ? app_storage_path("framework") : app_view_path();

        $this->engine = new BladeOne($path, app_cache_path(), BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.

   }

    /**
     * @throws Exception
     */
    public function render(string $view, array $data = []): string
    {

        return $this->engine->run($view, $data);
    }
}