@php
    $options = $attributes->class(['form-control', $class])->getAttributes();
    $prefix = config('laka-core.prefix');
@endphp
<div class="{{$groupClass}}">
    {!! Form::textarea($name, $value, $options) !!}

    @include("{$prefix}::components.forms.help-block")

    @include("{$prefix}::components.forms.errors")
</div>
