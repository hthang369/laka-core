@php
$options = $attributes->class(['btn', "btn-$variant", $btnSize])->merge(['type' => $type])->getAttributes();
if (array_key_exists('data-trigger-confirm', $options)) {
    $options = array_add($options, 'data-loading', translate('table.loading_text'));
}
@endphp
{!! Form::{$btnType}($text, $options) !!}
