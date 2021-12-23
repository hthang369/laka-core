<div {!! $attributes->merge($attrs) !!}>
    @if (blank($slot->toHtml()))
        {!! $label !!}
    @else
        {!! $slot !!}
    @endif
</div>
