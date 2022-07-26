<div {!! $attributes->merge($attrs) !!}>
    @if (blank($header))
        {!! $header !!}
    @else
        @php($headerCompo = "{$prefix}::common.card-header")
        <x-dynamic-component :component="$headerCompo" :text="$header" />
    @endif

    {{-- @if ($imgSrc && $imgTop)
        <x-image :src="{{$imgSrc}}" />
    @endif --}}

    @if (!$noBody)
        <x-card-body class="{{$bodyClass}}">
            @if (blank($title))
                {!! $title !!}
            @else
                @php($titleCompo = "{$prefix}::common.card-title")
                <x-dynamic-component :component="$titleCompo" :text="$title" />
            @endif

            {!! $slot !!}
        </x-card-body>
    @else
        {!! $slot !!}
    @endif

    {{-- @if ($imgSrc && $imgBottom)
        <x-image :src="{{$imgSrc}}" />
    @endif --}}

    @if (blank($footer))
        {!! $footer !!}
    @else
        @php($footerCompo = "{$prefix}::common.card-footer")
        <x-dynamic-component :component="$footerCompo" :text="$footer" />
    @endif
</div>
