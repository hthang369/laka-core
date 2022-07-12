@php
    $errorClass = $errors->has($name) ? 'is-invalid' : '';
    $options = $attributes->class(array_filter(['form-control', $class, $errorClass]))->getAttributes();
    $prefix = config('laka-core.prefix');
@endphp
@if ($groupClass)
<div class="{{$groupClass}}">
@endif

@if (!empty($icon))
<div class="input-group">
    @if ($prepent)
    <div class="input-group-prepend">
        <span class="input-group-text">@icon($icon)</span>
    </div>
    @endif
@endif

    {!! Form::input($type, $name, $value, $options) !!}

    @include("{$prefix}::components.forms.help-block")

    @include("{$prefix}::components.forms.errors")

@if (!empty($icon))
    @if (!$prepent)
    <div class="input-group-append">
        <span class="input-group-text">@icon($icon)</span>
    </div>
    @endif
</div>
@endif

@if ($groupClass)
</div>
@endif
