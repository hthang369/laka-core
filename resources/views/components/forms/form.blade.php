{!! Form::open($attributes->merge(['route' => $route, 'method' => $method])->getAttributes()) !!}
{!! $slot !!}
{!! Form::close() !!}
