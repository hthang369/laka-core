@php
    $allowedPageSize = config('laka.pager.allowedPageSizes');
    $items = array_combine($allowedPageSize, $allowedPageSize);
@endphp
<div class="pager-dropdown d-flex align-items-center">
    {!! Form::select('perPage', $items, request('perPage', config('laka.pagination.perPage')), ['class' => 'custom-select custom-select-sm', 'id' => 'pager-dropdown']) !!}
</div>
