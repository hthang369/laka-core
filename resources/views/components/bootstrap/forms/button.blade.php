@php
    $className = data_get($options, 'class');
    $icon = data_get($options, 'icon');
    $confirmMsg = data_get($options, 'data-confirmation-msg');
    $options = array_except($options, ['class', 'icon', 'data-confirmation-msg']);
    $variant = blank($variant) ? 'secondary' : $variant;
    $options = array_merge($options, compact('type'));
    if ($confirmMsg) {
        data_set($options, 'onclick', "return confirm('$confirmMsg')");
    }
    $content = blank($icon) ? $text : "<i class='fa {$icon} mr-1'></i>".$text;
@endphp
@if ((!blank($action) && !blank($sectionCode)))
@can("{$action}_{$sectionCode}")
{!! Form::{$btnType}($content, array_merge(['class' => array_css_class(['btn', "btn-{$variant}", $className])], $options)) !!}
@endcan
@else
{!! Form::{$btnType}($content, array_merge(['class' => array_css_class(['btn', "btn-{$variant}", $className])], $options)) !!}
@endif
