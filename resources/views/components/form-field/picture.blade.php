<x-form-group
    :inline="data_get($options, 'wrapper.inline', false)">
    @if ($showLabel)
        {!! Form::label($options['label_for'], $options['label'], $options['label_attr']) !!}
    @endif

    <div {!! Html::attributes(data_get($options, 'field_attr', [])) !!}>
    {!! Html::image(data_get($options, 'url').$options['value'], data_get($options, 'alt'), $options['attr']) !!}
    </div>
</x-form-group>
