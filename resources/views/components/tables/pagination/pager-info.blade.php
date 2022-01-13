<span class="pager-info d-flex align-items-center">
    {!! sprintf(
            translate(config('laka.pager.infoText')),
            $paginator->firstItem(),
            $paginator->lastItem(),
            $paginator->total()
        ) !!}
</span>
