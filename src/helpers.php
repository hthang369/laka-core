<?php

use Illuminate\Support\Arr;

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
    function array_css_class($arrClass)
    {
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
	function highlight_code($str)
	{
		/* The highlight string function encodes and highlights
		 * brackets so we need them to start raw.
		 *
		 * Also replace any existing PHP tags to temporary markers
		 * so they don't accidentally break the string out of PHP,
		 * and thus, thwart the highlighting.
		 */
		$str = str_replace(
			array('&lt;', '&gt;', '<?', '?>', '<%', '%>', '\\', '</script>'),
			array('<', '>', 'phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			$str
		);

		// The highlight_string function requires that the text be surrounded
		// by PHP tags, which we will remove later
		$str = highlight_string($str, TRUE);

		// Remove our artificially added PHP, and the syntax highlighting that came with it
		$str = preg_replace(
			array(
				'/<span style="color: #([A-Z0-9]+)">&lt;\?php(&nbsp;| )/i',
				'/(<span style="color: #[A-Z0-9]+">.*?)\?&gt;<\/span>\n<\/span>\n<\/code>/is',
				'/<span style="color: #[A-Z0-9]+"\><\/span>/i'
			),
			array(
				'<span style="color: #$1">',
				"$1</span>\n</span>\n</code>",
				''
			),
			$str
		);

		// Replace our markers back to PHP tags.
		return str_replace(
			array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'),
			$str
		);
	}
}

if (!function_exists('laka_link_method')) {
    function laka_link_method($method, $link, $title = null, $variant = null, $parameters = [], $attributes = [], $action = null, $sectionCode = null, $secure = null, $escape = true)
    {
        $icon = data_get($attributes, 'icon');
        $content = $title;
        if (!blank($icon)) {
            $content = "<i class='fa {$icon} mr-1'></i>".$title;
            $escape = false;
        }
        $variant = $variant ?? 'secondary';
        $confirmMsg = data_get($attributes, 'data-confirmation-msg');
        $classAttrs = array_unique(array_merge(['btn', "btn-{$variant}"], explode(' ', data_get($attributes, 'class', ''))));
        $attributesNew = array_add(array_except($attributes, ['icon', 'class', 'data-confirmation-msg']), 'class', array_css_class($classAttrs));
        if ($confirmMsg)
            data_set($attributesNew, 'onclick', "return confirm('$confirmMsg')");

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
