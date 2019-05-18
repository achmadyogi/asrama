<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DormAuthClass extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'DormAuthClass';
    }
}

?>