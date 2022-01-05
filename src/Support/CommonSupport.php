<?php
namespace Laka\Core\Support;

use Illuminate\Support\Facades\Request;

class CommonSupport
{
    public function getSectionCode()
    {
        if (\is_null(Request::route())) return '';
        $routeName = explode('.', Request::route()->getName());
        return trim(head($routeName));
    }

    public function getObjectProperty($object, $prop)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property;
    }

    public function setProtectedProperty($object, $key, $value)
    {
        $property = $this->getObjectProperty($object, $key);
        $property->setValue($object, $value);
    }

    public function getProtectedProperty($object, $prop)
    {
        $property = $this->getObjectProperty($object, $prop);
        return $property->getValue($object);
    }

    public function mergeProtectedProperty($object, $prop, $value)
    {
        $default = $this->getProtectedProperty($object, $prop);
        $newValue = $value;
        if (is_array($default)) {
            if (is_array($value))
                $newValue = array_merge($default, $value);
            else
                array_unshift($newValue, $default);
        }
        $this->setProtectedProperty($object, $prop, $newValue);
    }

    public function removeProtectedProperty($object, $prop, $value)
    {
        $default = $this->getProtectedProperty($object, $prop);
        if (is_array($default)) {
            $idx = array_search($value, $default);
            array_splice($default, $idx, 1);
        }
        $this->setProtectedProperty($object, $prop, $default);
    }
}
