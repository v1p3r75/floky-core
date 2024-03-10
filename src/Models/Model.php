<?php

use Floky\Facades\Config;
use Nexa\Models\Model as BaseModel;

class Model extends BaseModel
{

    protected $_config_path = app_config_path('database.php');

}