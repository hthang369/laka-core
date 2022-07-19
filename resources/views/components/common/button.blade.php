@php
$options = $attributes->merge($attrs)->getAttributes();
if (array_key_exists('data-trigger-confirm', $options)) {
    $options = array_add($options, 'data-loading', translate('table.loading_text'));
}
@endphp
{!! Form::{$btnType}($text ?: $slot, $options) !!}
