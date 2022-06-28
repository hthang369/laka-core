<?php
namespace Laka\Core\Support;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
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

    public function getViewName($name)
    {
        $prefix = config('laka-core.prefix');
        return "{$prefix}::components.{$name}";
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

    public function callApi($method, $url, $params = [], $headers = [])
    {
        $headers = array_merge(['Accept' => 'application/json'], $headers);
        try {
            $response = Http::withHeaders($headers)->{$method}($url, $params);

            if ($response->ok())
                return $response->collect();

            return $response->body();
        } catch(ConnectionException $e) {
            throw $e;
        }
    }

    public function getOptionsByEnumType($enumClass)
    {
        $reflector = new \ReflectionClass($enumClass);
        $instance = resolve($enumClass);
        return array_map(function($item) use($instance) {
            return trans(call_user_func([$instance, 'getTranslate'], $item));
        }, array_flip($reflector->getConstants()));
    }

    public function getLookupOptionsByEnumType($enumClass)
    {
        $data = $this->getOptionsByEnumType($enumClass);
        $lookup = [];
        foreach($data as $key => $value) {
            $lookup[] = ['id' => $key, 'name' => $value];
        }
        return $lookup;
    }

    public function formatBadge($value, $variant = 'secondary')
    {
        return sprintf('<span class="badge badge-%s">%s</span>', $variant, $value);
    }
}
