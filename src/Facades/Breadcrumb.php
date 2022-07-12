<?php

namespace Laka\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Breadcrumb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumb-support';
    }
}
