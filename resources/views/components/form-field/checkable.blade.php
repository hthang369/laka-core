<x-form-group :class="data_get($options, 'wrapper.class')"
    :inline="data_get($options, 'wrapper.inline', false)">
    @if ($showLabel)
        {!! Form::label(data_get($options, 'label.for', ''), $options['label'], $options['label_attr']) !!}
    @endif

    @if ($showField)
        @if($layout == 'grid')
            <div class="{{array_css_class(data_get($options, 'attr.wrapper'))}}">
        @endif
            <div class="custom-control custom-{{$type}} py-2">
                {!! Form::{$type}($name, $options['value'], $options['checked'], array_except($options['attr'], ['wrapper', 'label'])) !!}
                {!! Form::label(data_get($options, 'attr.label.for'), data_get($options, 'attr.label.text'), data_get($options, 'attr.label.attr')) !!}
            </div>

            @if ($showError)
                @include(laka_component('form-field.errors'))
            @endif
        @if($layout == 'grid')
            </div>
        @endif
    @endif
</x-form-group>
