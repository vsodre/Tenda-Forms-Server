<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImageProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Services\ImageBuilder');
    }
}
