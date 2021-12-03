@php
    $attrId = [];
    if (!$attributes->has('id')) {
        $attrId = ['id' => $name];
    }
    $options = $attributes->class($class)->merge($attrId)->getAttributes();
    $prefix = config('laka-core.prefix');
@endphp
<div class="radio-group">
<div class="{{$chkGroupCLass}}">
    {!! Form::radio($name, $value, $checked, $options) !!}
    {!! Form::label($name, $label, $labelAttr) !!}
</div>

@include("{$prefix}::components.forms.help-block")

@if ($showError)
    @include("{$prefix}::components.forms.errors")
@endif
</div>
