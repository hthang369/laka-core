@php
$prefix = config('laka-core.prefix');
@endphp
<div class="{{$responsive}}">
    <table {{ $attributes->class($tableClass) }}>
        @include("{$prefix}::components.tables.table-header")
        <tbody>
            @forelse ($items as $item)
                <x-table-row>
                    @foreach ($fields as $field)
                        @continue(!$field->visible)
                        <x-table-column :field="$field" :data="$item">
                            @if (!is_null($field->lookup->dataSource))
                                {!! data_get($field->lookup->items, data_get($item, $field->key)) !!}
                            @else
                                {!! data_get($item, $field->key) !!}
                            @endif
                        </x-table-column>
                    @endforeach
                </x-table-row>
            @empty
                @php
                    $field = new Laka\Core\Grids\DataColumn;
                    $field->tdAttr = ['colspan' => count($fields)];
                @endphp
                <x-table-row>
                    <x-table-column :field="$field">
                        <x-alert type="warning">
                            @lang("$prefix::table.no_item_found")
                        </x-alert>
                    </x-table-column>
                </x-table-row>
            @endforelse
        </tbody>
    </table>
</div>

@section('paginator-info')
    @if (is_array($pagination))
        <x-pagination
            :items="$items"
            :total="$pagination['total']"
            :current="$pagination['currentPage']"
            :pages="$pagination['pages']"
            :except="$pagination['except']" />
    @elseif (!is_null($pagination))
        {!! $pagination->links() !!}
    @endif
@show
