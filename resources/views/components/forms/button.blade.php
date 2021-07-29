
@php
    $options = $attributes->class($class)->merge(['type' => $type])->getAttributes();
@endphp
{!! Form::button($label, $options) !!}
