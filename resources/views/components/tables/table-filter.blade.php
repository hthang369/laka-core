<td {{$attributes->merge(['scope' => 'col'])}}>
    @if (!blank($field->cell) && is_callable($field->cell) && !is_null($cellData))
        {!! with($cellData, $field->cell); !!}
    @elseif (str_is($field->dataType, 'buttons'))
        {!! Form::button('<i class="fas fa-filter"></i>', ['class' => 'btn btn-sm btn-outline-primary ml-2', 'onclick' => 'filterAction()']) !!}
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
@once
@push('scripts')
<script>
    function filterAction() {
        let params = new URLSearchParams(location.search)
        $('.table_filter').find('input').each(function(idx, item) {
            if (item.value) {
                params.set(item.name, item.value)
            } else {
                params.delete(item.name)
            }
        });
        let url = params.toString() == '' ? '' : '?' + params.toString();
        let fullUrl = new URL(url, '{{request()->url()}}');
        window.location.replace(fullUrl.toString());
    }
</script>
@endpush
@endonce
