<?php

namespace Laka\Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LakaCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $prefix = config('laka-core.prefix');

        $this->loadViewsFrom(__DIR__.'/../resources/views', $prefix);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', $prefix);

        collect(config('laka-core.components'))->each(function($item, $alias) {
            Blade::component($alias, $item['class']);
        });

        require_once(__DIR__.'/helpers.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laka-core');
    }
}
