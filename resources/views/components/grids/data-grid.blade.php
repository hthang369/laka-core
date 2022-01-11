@section('caption_page')
    {!! $grid->renderHeaderInfo() !!}
@show
<x-table
    :responsive="true"
    bordered
    hover
    :id="$grid->getId()"
    :sectionCode="$sectionCode"
    :items="data_get($data, 'rows')"
    :fields="data_get($data, 'fields')"
    :pagination="data_get($data, 'paginator')">
</x-table>
@push('scripts')
<script>
    (function($) {
        var grid = "{{ '#' . $grid->getId() }}";
        var filterForm = ""; //"'#' . $grid->getFilterFormId() ";
        _grids.grid.init({
          id: grid,
          filterForm: {
            target: '.table_filter',
            btnName: '.btn-filter',
            routeLink: '{{request()->url()}}'
          },
          pagerDropdown: {
            target: '#pager-dropdown',
            routeLink: '{{request()->url()}}'
          },
          pjax: {
            pjaxOptions: {
              scrollTo: false,
              timeout: 3000
            },
            // what to do after a PJAX request. Js plugins have to be re-intialized
            afterPjax: function(e) {
              _grids.init();
            },
          },
        });
        _grids.init()
      })(jQuery);
</script>
@endpush

