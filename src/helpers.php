<?php

if (!function_exists('get_classes')) {
    function get_classes($classes) {
        $result = [];
        $spacer = ' ';

        foreach($classes as $class) {
            if (isset($class['class']) && !empty($class['class'])) {
                array_push($result, $class['class']);
            } elseif(!empty($class) && !is_array($class)) {
                array_push($result, $class);
            }
        }

        return implode($spacer, $result);
    }
}

if (!function_exists('translate')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function translate($key = null, $replace = [], $locale = null) {
        $prefix = config('laka-core.prefix');
        return trans($prefix.'::'.$key, $replace, $locale);
    }
}

if (!function_exists('laka_public_path')) {
    function laka_public_path($path) {
        if (file_exists(public_path($path)))
            return public_path($path);
        else
            return __DIR__.'/../public/'.$path;
    }
}
