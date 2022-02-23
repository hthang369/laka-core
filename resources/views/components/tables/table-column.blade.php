<{{$tag}} {{ $attributes->class([$field->class])->merge(array_merge(['scope' => 'col'], $field->tdAttr)) }}>
    @if ((blank($field->cell) && blank($field->formatter)) || $isRowHeader)
        {!! $slot !!}
    @elseif (is_callable($field->cell))
        {!! with($cellData, $field->cell); !!}
    @elseif (is_callable($field->formatter))
        {!! call_user_func_array($field->formatter, [data_get($cellData, $field->key), $field->key, $cellData]); !!}
    @else
        <x-dynamic-component :component="$field->cell" :data="$cellData"/>
    @endif

    @if ($field->sortable && $isRowHeader)
        <x-table-sort :field="$field->key" />
    @endif
</{{$tag}}>
