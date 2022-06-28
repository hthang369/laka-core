<x-form-group :class="data_get($options, 'wrapper.class')"
    :inline="data_get($options, 'wrapper.inline', false)">
    @if ($showLabel)
        {!! Form::label(data_get($options, 'label.for', ''), $options['label'], $options['label_attr']) !!}
    @endif

    @if ($showField)
        @if($layout == 'grid')
            <div class="{{array_css_class(data_get($options, 'attr.wrapper'))}}">
        @endif
            <div class="custom-{{$type}}-group">
                @foreach ($options['choices'] as $key => $display)
                    <div {!! Html::attributes(data_get($options, 'attr.control', [])) !!}>
                        {!! Form::$type($name, $key, in_array($key, data_get($options, 'value', [])), array_merge(array_except($options['attr'], ['wrapper']), ['id' => 'checkable_'.$key])) !!}
                        {!! Form::label('checkable_'.$key, $display, data_get($options, 'attr.label.attr', [])) !!}
                    </div>
                @endforeach
            </div>

            @if ($showError)
                @include(laka_component('form-field.errors'))
            @endif
        @if($layout == 'grid')
            </div>
        @endif
    @endif
</x-form-group>
