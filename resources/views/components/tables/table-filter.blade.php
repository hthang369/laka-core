<td {{$attributes->merge(['scope' => 'col'])}}>
    @if (!blank($field->cell) && is_callable($field->cell) && !is_null($cellData))
        {!! with($cellData, $field->cell); !!}
    @elseif (str_is($field->dataType, 'buttons'))
        {!! Form::button('<i class="fas fa-filter"></i>', ['class' => 'btn btn-sm btn-outline-primary ml-2 btn-filter']) !!}
    @else
        @if (str_is($field->dataType, 'date'))
            <x-dynamic-component :component="$type" :name="$field->key" :value="request($field->key)" />
        @elseif (str_is($type, 'select'))
            {!! Form::select($field->key, $field->lookup->items, request($field->key), ['class' => 'form-control form-control-sm', 'placeholder' => translate('table.select')]) !!}
        @else
            {!! Form::skipInput('text', $field->key, request($field->key), ['class' => 'form-control form-control-sm']) !!}
        @endif
    @endif
</td>
