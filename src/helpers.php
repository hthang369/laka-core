<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laka\Core\Plugins\Highlight\Highlighter;
use Laka\Core\Plugins\Highlight\Utilities\Functions;

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
        return laka_trans($prefix.'::'.$key, $replace, $locale);
    }
}

if (!function_exists('laka_trans')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function laka_trans($key = null, $replace = [], $locale = null) {
        $appLocale = $locale ?? App::getLocale();
        return trans($key, $replace, $appLocale);
    }
}

if (!function_exists('attributes_get')) {
    function attributes_get($attributes) {
        $attr = [];
        foreach ($attributes as $key => $value) {
            if (is_string($key))
                array_push($attr, sprintf('%s=%s', $key, $value));
            else
                array_push($attr, $value);
        }

        return join(' ', $attr);
    }
}

if (!function_exists('array_css_class')) {
    function array_css_class($arrClass, $isUnique = false)
    {
        if ($isUnique) {
            $arrClass = array_unique($arrClass);
        }
        return Arr::toCssClasses($arrClass);
    }
}

if ( ! function_exists('highlight_code'))
{
	/**
	 * Code Highlighter
	 *
	 * Colorizes code strings
	 *
	 * @param	string	the text string
	 * @return	string
	 */
	function highlight_code($str, $lang)
	{
		$hl = new Highlighter();
        // $code = join("\n", array_map('trim', explode("\n", $str)));
        $code = $str;
        try {
            // Highlight some code.
            $highlighted = $hl->highlight($lang, $code);

            echo "<pre><code class=\"hljs {$highlighted->language}\">";
            echo $highlighted->value;
            echo "</code></pre>";
        }
        catch (DomainException $e) {
            // This is thrown if the specified language does not exist

            echo "<pre><code>";
            echo htmlentities($code);
            echo "</code></pre>";
        }

        $style = Functions::getStyleSheet('paraiso-dark');

        echo "<style>$style</style>";
	}
}

if (!function_exists('laka_link_method')) {
    function laka_link_method($method, $link, $title = null, $variant = null, $parameters = [], $attributes = [], $action = null, $sectionCode = null, $secure = null, $escape = true)
    {
        $icon = array_pull($attributes, 'icon');
        $content = $title;
        if (!blank($icon)) {
            $content = "<i class='fa {$icon} mr-1'></i>".$title;
            $escape = false;
        }
        $variant = $variant ?? 'secondary';
        $ajaxConfirm = array_pull($attributes, 'web-confirm');
        $classAttrs = array_unique(array_merge(['btn', "btn-{$variant}"], explode(' ', array_pull($attributes, 'class', ''))));
        $attributesNew = array_add($attributes, 'class', array_css_class($classAttrs));
        if ($ajaxConfirm) {
            $confirmMsg = array_pull($attributesNew, 'data-confirmation-msg');
            data_set($attributesNew, 'onclick', "return confirm('$confirmMsg')");
        }
        if (array_key_exists('data-trigger-confirm', $attributesNew)) {
            $attributesNew = array_add($attributesNew, 'data-loading', translate('table.loading_text'));
        }

        if (str_is($method, 'link'))
            return app('html')->{$method}($link, $content, $attributesNew, $secure, $escape);

        if (!blank($action) && !blank($sectionCode)) {
            if (user_can("{$action}_{$sectionCode}")) {
                return app('html')->{$method}($link, $content, $parameters, $attributesNew, $secure, $escape);
            } else {
                return '';
            }
        }

        return app('html')->{$method}($link, $content, $parameters, $attributesNew, $secure, $escape);
    }
}

if (!function_exists('bt_link_to')) {
    function bt_link_to($url, $title = null, $variant = null, $attributes = [], $action = null, $sectionCode = null, $secure = null, $escape = true)
    {
        return laka_link_method('link', $url, $title, $variant, [], $attributes, $action, $sectionCode, $secure, $escape);
    }
}

if (!function_exists('bt_link_to_route')) {
    function bt_link_to_route($name, $title = null, $variant = null, $parameters = [], $attributes = [], $action = null, $sectionCode = null, $secure = null, $escape = true)
    {
        return laka_link_method('linkRoute', $name, $title, $variant, $parameters, $attributes, $action, $sectionCode, $secure, $escape);
    }
}

if (!function_exists('bt_link_to_action')) {
    function bt_link_to_action($action, $title = null, $variant = null, $parameters = [], $attributes = [], $actionName = null, $sectionCode = null, $secure = null, $escape = true)
    {
        return laka_link_method('linkAction', $action, $title, $variant, $parameters, $attributes, $actionName, $sectionCode, $secure, $escape);
    }
}

if (!function_exists('user_get')) {
    function user_get($key = null)
    {
        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        }
        if (!is_null($key) && !is_null($user)) {
            return object_get($user, $key);
        }
        return $user;
    }
}

if (!function_exists('user_can')) {
    function user_can($action)
    {
        return (Auth::check() && Auth::user()->can($action));
    }
}

if (!function_exists('layouts_path')) {
    function layouts_path($module, $path, $themeName = null) {
        $themeName = $themeName ?? env('APP_THEMES');
        return "{$module}::layouts.themes.{$themeName}.{$path}";
    }
}

if (!function_exists('module_views_path')) {
    function module_views_path($module, $path) {
        return "{$module}::{$path}";
    }
}

if (!function_exists('laka_component')) {
    function laka_component($viewName) {
        $prefix = config('laka-core.prefix');
        return "{$prefix}::components.{$viewName}";
    }
}

if (! function_exists('array_merge_recursive_simple')) {
    function array_merge_recursive_simple(array &$array1, array $array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_string($key)) {
                if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                    $merged[$key] = array_merge_recursive_simple($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            } else {
                $merged[] = $value;
            }
        }

        return $merged;
    }
}

if (!function_exists('get_route_name')) {
    function get_route_name()
    {
        // return request()->route()->getName();
        return Route::currentRouteName();
    }
}

if (!function_exists('array_group_by_single')) {
    function array_group_by_single($data, $groupBy) {
        return collect($data)->groupBy($groupBy)->map(function($item) {
            return $item->first();
        });
    }
}
