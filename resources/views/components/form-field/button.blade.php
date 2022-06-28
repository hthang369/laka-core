{{-- @dd($options) --}}
<x-form-group
    :inline="data_get($options, 'wrapper.inline', false)">

    @if ($showField)
        @if($layout == 'grid')
            <div class="{{array_css_class(data_get($options, 'attr.wrapper'))}}">
        @endif

        {!! Form::button($options['label'], array_merge(compact('type', 'name'), array_except($options['attr'], ['wrapper', 'label']))) !!}

        @if($layout == 'grid')
            </div>
        @endif
    @endif
</x-form-group>
