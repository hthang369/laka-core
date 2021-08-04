<div {!! $attributes->merge($attrs) !!}{!! $attrs2 !!}>
  @if(isset($image['src']))
    <x-image {{ attributes_get($image) }}"/>
  @elseif(isset($icon))
    @icon($icon . $mediaObjectClass ?? '')
  @endif

  {!! $object ?? '' !!}

  <div{!! $body['attrs'] !!}>
    @if(!empty($headline))
      <x-headline {{ attributes_get($headline) }} />
    @endif

    {!! $text ?? '' !!}
    {!! $slot ?? '' !!}
  </div>
</div>
