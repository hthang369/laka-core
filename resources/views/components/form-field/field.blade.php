<x-form-group :class="data_get($options, 'wrapper.class')"
    :inline="data_get($options, 'wrapper.inline', false)">
    @if ($showLabel)
        {!! Form::label(data_get($options, 'label.for', ''), $options['label'], $options['label_attr']) !!}
    @endif

    @if ($showField)
        @if($layout == 'grid')
            <div class="{{array_css_class(data_get($options, 'attr.wrapper'))}}">
        @endif
            @yield('field_content')

            @if ($showError)
                @include(laka_component('form-field.errors'))
            @endif
        @if($layout == 'grid')
            </div>
        @endif
    @endif
</x-form-group>
