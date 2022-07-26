<thead>
    <x-table-row scope="header" class="{{$headerClass}}">
        @foreach ($fields as $field)
            @continue(!$field->visible)
            <x-table-column :field="$field" :isHeader="true" :rowType="header">
                {!! $field->label !!}
            </x-table-column>
        @endforeach
    </x-table-row>
    @if ($isFilters)
    <x-table-row scope="filter" class="table_filter">
        @foreach ($fields as $field)
            @continue(!$field->visible)
            @if ($field->filtering || str_is($field->dataType, 'buttons'))
                <x-table-filter class="p-1" :field="$field" />
            @else
                <x-table-column :field="new Laka\Core\Grids\DataColumn" :rowType="filter" />
            @endif
        @endforeach
    </x-table-row>
    @endif
</thead>
