<header>
  <a href="{{ home_url('/') }}">
    @if ((string) $logoUrl)
      <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
    @else
      {{ $siteName }}
    @endif
  </a>

  <nav aria-label="{{ __('Primary', 'sage') }}">
    @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'container' => false,
        'items_wrap' => '<ul>%3$s</ul>',
        'fallback_cb' => false,
        'echo' => false,
      ]) !!}
    @endif
    <a href="{{ $appUrl }}">{{ $loginLabel }}</a>
  </nav>
</header>
