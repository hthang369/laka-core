@php
    $options = $attributes->class($class)->getAttributes();
    $prefix = config('laka-core.prefix');
@endphp
<div class="{{$groupClass}}">

    {!! Form::select($name, $items, $selected, $options) !!}

    @include("{$prefix}::components.forms.help-block")

    @include("{$prefix}::components.forms.errors")

</div>
