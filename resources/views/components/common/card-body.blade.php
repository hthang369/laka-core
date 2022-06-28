<{{$tag}} {!! $attributes->class($bodyClass) !!}>
    @if (blank($title))
        {!! $title !!}
    @else
        @php($titleCompo = "{$prefix}::common.card-title")
        <x-dynamic-component :component="$titleCompo" :text="$title" />
    @endif

    {!! $slot !!}
</{{$tag}}>
