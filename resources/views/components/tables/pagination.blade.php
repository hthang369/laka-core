<nav>
  <ul {!! $attributes->merge($attrs) !!}>
    <li class="page-item {{ $current == 1 ? 'disabled' : '' }}">
      <a class="page-link" href="{{ $prev['href'] ?? '' }}">{!! $prev['text'] ?? 'Previous' !!}</a>
    </li>
    @foreach ($links as $link)
      <li {!! $link['active'] ? 'class="page-item active"  aria-current="page"' : 'class="page-item"' !!}>
        @if (empty($link['url']))
            <span class="page-link">{{$link['label']}}</span>
        @else
            <a class="page-link" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
        @endif
      </li>
    @endforeach
    <li class="page-item {{ $current == $pages ? 'disabled' : '' }}">
      <a class="page-link" href="{{ $next['href'] ?? '' }}">{!! $next['text'] ?? 'Next' !!}</a>
    </li>
  </ul>
</nav>
