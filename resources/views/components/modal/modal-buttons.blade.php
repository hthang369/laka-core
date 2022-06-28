<x-button text="{{'Close'}}" icon="fa fa-times" size="sm" variant="danger" data-dismiss="modal" />
@if (!ends_with(get_route_name(), 'show'))
<x-button type="submit" icon="fa fa-save" size="sm" variant="success" text="{{'Save'}}" data-loading="{{translate('table.loading_text')}}" />
@endif
