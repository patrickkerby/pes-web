<footer>
  <div>
    <a href="{{ home_url('/') }}">
      @if ((string) $logoUrl)
        <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}">
      @else
        {{ $siteName }}
      @endif
    </a>

    <div>
      <h3>{{ $footerCompany }}</h3>
      @if ($address)
        <p>{!! $address !!}</p>
      @endif
      @if ($phone)
        <p><a href="{{ $phoneHref }}">{{ $phone }}</a></p>
      @endif
    </div>

    <div>
      <h3>{{ $footerBusinessesHeading }}</h3>
      @if ($email)
        <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
      @endif
    </div>

    <div>
      <h3>{{ $footerQuotesHeading }}</h3>
      @if ($estimatingEmail)
        <p><a href="mailto:{{ $estimatingEmail }}">{{ $estimatingEmail }}</a></p>
      @endif
    </div>
  </div>

  <p>{{ $footerLegal }}</p>
</footer>
