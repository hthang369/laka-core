<?php

namespace Laka\Core;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laka\Core\Facades\Common;
use Laka\Core\Support\CommonSupport;

class LakaCoreServiceProvider extends ServiceProvider
{
    private $initFacades = [
        'common-support' => CommonSupport::class
    ];

    private function getPrefix()
    {
        return config('laka-core.prefix');
    }

    public function boot()
    {
        $prefix = $this->getPrefix();

        $this->loadViewsFrom(__DIR__.'/../resources/views', $prefix);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', $prefix);

        $this->registerFacades();

        $this->registerBladeComponents();

        $this->registerFormComponents();

        $this->loadHelperFile();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/laka.php' => config_path('laka.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views/components/grids/header-info.blade.php' => resource_path("views/vendor/{$prefix}/components/grids/header-info.blade.php"),
            ], ['laka-views']);
        }
    }

    private function loadHelperFile()
    {
        require_once(__DIR__.'/helpers.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laka-core');
        $this->mergeConfigFrom(__DIR__ . '/../config/laka.php', 'laka');
    }

    protected function registerBladeComponents()
    {
        collect(config('laka-core.components'))->each(function($item, $alias) {
            Blade::component($alias, $item['class']);
        });

        Blade::directive('icon', function ($expression) {
            return '<i class="'."<?php echo e($expression); ?>".'"></i>';
        });
    }

    protected function registerFormComponents()
    {
        $prefix = $this->getPrefix();

        collect(config('laka-core.form-components'))->each(function($item, $alias) use($prefix) {
            Form::component($alias, $prefix.'::'.$item['view'], $item['params']);
        });

        Form::macro('skipInput', function(...$params) {
            list($type, $name, $value, $options) = $params;
            Common::mergeProtectedProperty(app('form'), 'skipValueTypes', [$type]);
            $html = Form::input($type, $name, $value, $options);
            Common::removeProtectedProperty(app('form'), 'skipValueTypes', $type);
            return $html;
        });
    }

    protected function registerFacades()
    {
        foreach($this->initFacades as $key => $class) {
            $this->app->singleton($key, function () use($class) {
                return new $class();
            });
        }
    }
}
