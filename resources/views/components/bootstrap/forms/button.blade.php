@php
    $className = data_get($options, 'class');
    $icon = data_get($options, 'icon');
    $options = array_except($options, ['class', 'icon']);
    $variant = blank($variant) ? 'secondary' : $variant;
    $options = array_merge($options, compact('type'));
    $content = blank($icon) ? $text : "<i class='fa {$icon} mr-1'></i>".$text;
@endphp
{!! Form::{$btnType}($content, array_merge(['class' => array_css_class(['btn', "btn-{$variant}", $className])], $options)) !!}
