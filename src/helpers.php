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
