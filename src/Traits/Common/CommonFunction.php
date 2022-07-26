<?php
namespace Laka\Core\Traits\Common;

use Illuminate\Support\Facades\Request;

trait CommonFunction
{
    public function getSectionCode()
    {
        if (is_null(Request::route())) return '';
        $routeName = explode('.', Request::route()->getName());
        return trim(head($routeName));
    }

    public function getCurrentModuleName()
    {
        $calledClass = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, get_called_class());
        $arr = explode(DIRECTORY_SEPARATOR, $calledClass);
        return strtolower(data_get($arr, 1));
    }

    public function getLayoutModuleName()
    {
        return $this->layoutModuleName ?? $this->getCurrentModuleName();
    }
}
