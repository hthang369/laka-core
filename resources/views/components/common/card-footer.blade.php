@props(['text'])
<div {!! $attributes->class(['card-footer']) !!}>
    {{ $text }}
    {!! $slot !!}
</div>
