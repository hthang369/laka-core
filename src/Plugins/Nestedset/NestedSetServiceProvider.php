<?php

namespace Laka\Core\Plugins\Nestedset;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class NestedSetServiceProvider extends ServiceProvider
{
    public function register()
    {
        Blueprint::macro('nestedSet', function (...$options) {
            NestedSet::columns($this, head($options));
        });

        Blueprint::macro('dropNestedSet', function (...$options) {
            NestedSet::dropColumns($this, head($options));
        });
    }
}
