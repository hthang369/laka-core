<x-form-group
    :inline="data_get($options, 'wrapper.inline', false)">
    @if ($showLabel)
        {!! Form::label($options['label_for'], $options['label'], $options['label_attr']) !!}
    @endif

    <div class="map embed-responsive embed-responsive-16by9">
    {!! Html::tag($options['tag'], $options['value'], $options['attr']) !!}
    </div>
</x-form-group>
