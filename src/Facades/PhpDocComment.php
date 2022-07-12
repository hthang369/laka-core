<?php
namespace Laka\Core\Facades;

use Illuminate\Support\Facades\Facade;

class PhpDocComment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'phpdoc-comment';
    }
}
