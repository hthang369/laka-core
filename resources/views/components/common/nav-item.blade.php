<{{$tag}} {{ $attributes->class('nav-item') }}>
<x-link :href="$href" :target="$target" {{ $attributes->merge($linkAttrs->getAttributes()) }}>
    {{ $slot }}
</x-link>
</{{$tag}}>
