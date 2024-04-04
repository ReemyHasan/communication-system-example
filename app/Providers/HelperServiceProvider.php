<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $files = glob(app_path('Http/Helpers') . "/*.php");
        foreach ($files as $key => $file) {
            require_once $file;
        }
    }
}
