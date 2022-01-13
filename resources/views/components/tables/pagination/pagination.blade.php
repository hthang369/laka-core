@php
$prefix = config('laka-core.prefix');
@endphp
@if ($paginator->hasPages())
<div class="paginatior d-flex justify-content-between">
    @if ($showPageSize)
    @include("{$prefix}::components.tables.pagination.pager-dropdown")
    @endif
    @include("{$prefix}::components.tables.pagination.paginarion-pager")
    @if ($showInfo)
    @include("{$prefix}::components.tables.pagination.pager-info")
    @endif
</div>
@endif

