<div {!! $attributes->merge($attrs) !!}>
    @if (blank($slot->toHtml()))
        <x-progress-bar
            :animated="$animated"
            :max="$max"
            :striped="$striped"
            :variant="$variant"
            :show-progress="$showProgress"
            :show-value="$showValue"
            :value="$value"
            :precision="$precision"
        ></x-progress-bar>
    @else
        {!! $slot !!}
    @endif
</div>
