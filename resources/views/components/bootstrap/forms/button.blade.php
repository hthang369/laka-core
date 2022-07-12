@php
    $className = array_pull($options, 'class');
    $icon = array_pull($options, 'icon');
    $ajaxConfirm = array_pull($options, 'web-confirm');
    $variant = blank($variant) ? 'secondary' : $variant;
    $options = array_merge($options, compact('type'));
    if ($ajaxConfirm) {
        $confirmMsg = array_pull($options, 'data-confirmation-msg');
        if ($confirmMsg) {
            data_set($options, 'onclick', "return confirm('$confirmMsg')");
        }
    }
    if (array_key_exists('data-trigger-confirm', $options)) {
        $options = array_add($options, 'data-loading', translate('table.loading_text'));
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
