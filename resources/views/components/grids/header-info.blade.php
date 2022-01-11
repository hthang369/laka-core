<div class="d-flex justify-content-between">
    <p class="d-flex align-items-center">
        <label class="mr-2"><b>@lang('common.total'):</b></label>
        <label>{{ $total }}</label>
    </p>

    @if ($pages > 0)
    <p class="">
        <b>@lang('common.pages')</b>
        <label>{{ $currentPage }} / {{ $pages }}</label>
    </p>
    @endif
</div>
