<?php
namespace Laka\Core\Traits;

use Illuminate\Support\Facades\Request;

trait CommonFunction
{
    public function getSectionCode()
    {
        if (is_null(Request::route())) return '';
        $routeName = explode('.', Request::route()->getName());
        return trim(head($routeName));
    }
}
