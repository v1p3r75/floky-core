<?php

namespace Floky\Models;

use Nexa\Models\Model as BaseModel;

class Model extends BaseModel
{

    public function __construct() {

        $this->setConfigPath(app_config_path('database.php'));
        parent::__construct();

    }

}