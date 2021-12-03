@php
    $attrId = [];
    if (!$attributes->has('id')) {
        $attrId = ['id' => $name];
    }
    $options = $attributes->class($class)->merge($attrId);
    $labelFor = $options->get('id');
    $prefix = config('laka-core.prefix');
@endphp
<div class="checkbox-item">
<div class="{{$chkGroupCLass}}">
    {!! Form::checkbox($name, $value, $checked, $options->getAttributes()) !!}
    {!! Form::label($labelFor, $label, $labelAttr) !!}
</div>

@include("{$prefix}::components.forms.help-block")

@if ($showError)
    @include("{$prefix}::components.forms.errors")
@endif
</div>
