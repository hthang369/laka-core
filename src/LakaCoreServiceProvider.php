<?php

namespace Laka\Core;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Blade;
use Laka\Core\Facades\Common;
use Laka\Core\Plugins\Nestedset\NestedSetServiceProvider;
use Laka\Core\Support\BreadcrumbSupport;
use Laka\Core\Support\CommonSupport;
use Laka\Core\Support\ModalHelper;
use Laka\Core\Support\PhpDocCommentSupport;

class LakaCoreServiceProvider extends BaseServiceProvider
{
    protected $facades = [
        'common-support' => CommonSupport::class,
        'modal'  => ModalHelper::class,
        'breadcrumb-support' => BreadcrumbSupport::class,
        'phpdoc-comment' => PhpDocCommentSupport::class
    ];

    protected $loadConfigs = [
        'laka-core'     => 'config.php',
        'laka'          => 'laka.php',
        'permission'    => 'permission.php',
        'modules'       => 'modules.php',
        'form-builder' => 'form-builder.php',
    ];

    protected $publishConfigs = [
        // 'laka'          => 'laka.php',
        'form-builder' => 'form-builder.php',
    ];

    protected $moduleNamespace = 'Laka\\Core\\';
    protected $modulePath = __DIR__;
    protected $commandPath = __DIR__.DIRECTORY_SEPARATOR.'Console';

    private function getPrefix()
    {
        return config('laka-core.prefix');
    }

    public function boot()
    {
        $prefix = $this->getPrefix();

        $this->loadViewsFrom(__DIR__.'/../resources/views', $prefix);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', $prefix);

        $this->registerBladeComponents();

        $this->registerFormComponents();

        $this->loadHelperFile();

        $this->registerCommands();

        if ($this->app->runningInConsole()) {
            $this->publishConfigs();

            // $this->publishes([
            //     __DIR__.'/../resources/views/components/grids/header-info.blade.php' => resource_path("views/vendor/{$prefix}/components/grids/header-info.blade.php"),
            // ], ['laka-views']);
        }
    }

    public function register()
    {
        $this->app->register(NestedSetServiceProvider::class);
        parent::register();
    }

    private function loadHelperFile()
    {
        require_once(__DIR__.'/helpers.php');
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
}
