<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Engines\ITBdormClass;

class ITBdormServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('ITBdormClass', function () {
            return new ITBdormClass;
        });
    }
}

?>