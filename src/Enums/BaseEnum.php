<?php
namespace Laka\Core\Enums;

abstract class BaseEnum
{
    protected $translate = [];

    public function getTranslate($key)
    {
        return data_get($this->translate, $key, $key);
    }
}
