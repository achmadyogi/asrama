<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Engines\DormAuthClass;

class DormAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('DormAuthClass', function () {
            return new DormAuthClass;
        });
    }
}

?>