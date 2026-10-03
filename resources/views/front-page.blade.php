@extends('layouts.app')

@section('content')
  <section class="hero"@if ((string) $heroBackground) style="--hero-image: url('{{ esc_url($heroBackground) }}')"@endif>
    <img src="{{ $heroMark }}" alt="" width="1045" height="1080" aria-hidden="true">
    <h1>{{ $heroTitle }}</h1>
    @if ($heroLede)
      <p>{{ $heroLede }}</p>
    @endif
    @if ($heroCtaLabel)
      <a href="{{ $heroCtaUrl }}">{{ $heroCtaLabel }}</a>
    @endif
  </section>

  <section class="beyond" id="who">
    <div data-enter>
      <div>
        @if ($beyondEyebrow)
          <p>{{ $beyondEyebrow }}</p>
        @endif
        <h2>{{ $beyondTitle }}</h2>
      </div>
      <div>
        {!! $beyondCopy !!}
      </div>
    </div>

    @if ($stats)
      <div class="stats">
        @foreach ($stats as $stat)
          <article data-enter>
            @if (! empty($stat['icon']['url']))
              <img src="{{ $stat['icon']['url'] }}" alt="" width="{{ $stat['icon']['width'] ?? 64 }}" height="{{ $stat['icon']['height'] ?? 64 }}">
            @else
              <span aria-hidden="true"></span>
            @endif
            <p>{{ $stat['label'] }}</p>
            <span>{{ $stat['sub_label'] }}</span>
          </article>
        @endforeach
      </div>
    @endif
  </section>

  @if ($services)
    <section class="services" id="services">
      <header data-enter>
        @if ($servicesEyebrow)
          <p>{{ $servicesEyebrow }}</p>
        @endif
        <h2>{{ $servicesTitle }}</h2>
      </header>
      <div>
        @foreach ($services as $item)
          <button type="button" data-service="{{ $item['slug'] }}" data-enter>
            <span>{{ $item['title'] }}</span>
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M5 12h14M13 6l6 6-6 6"/>
            </svg>
          </button>
        @endforeach
      </div>

      <div data-service-layer>
        <div data-backdrop></div>
        <div data-panel role="dialog" aria-modal="true" aria-hidden="true">
          <button type="button" data-close aria-label="{{ __('Close', 'sage') }}">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
          </button>
          @foreach ($services as $item)
            <article data-service-panel="{{ $item['slug'] }}" hidden>
              <p>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
              <h3 id="service-{{ $item['slug'] }}">{{ $item['title'] }}</h3>
              @if ($item['content'])
                <div data-service-body>
                  {!! wp_kses_post($item['content']) !!}
                </div>
              @endif
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="partners" id="partners">
    @if ($communityPartners)
      <div data-community data-enter>
        @if ($communityPartnersHeading)
          <p>{{ $communityPartnersHeading }}</p>
        @endif
        <div>
          @foreach ($communityPartners as $item)
            @include('partials.logo', ['item' => $item])
          @endforeach
        </div>
      </div>
    @endif

    @if ($supportOrgs)
      <div data-support data-enter>
        @if ($supportOrgsHeading)
          <p>{{ $supportOrgsHeading }}</p>
        @endif
        <div>
          @foreach ($supportOrgs as $item)
            @include('partials.logo', ['item' => $item])
          @endforeach
        </div>
      </div>
    @endif

    @if ($credentials || $credentialsLine)
      <div data-credentials data-enter>
        @if ($credentialsHeading)
          <p>{{ $credentialsHeading }}</p>
        @endif
        @if ($credentials)
          <div data-marquee>
            @foreach ($credentials as $item)
              @include('partials.logo', ['item' => $item])
            @endforeach
          </div>
        @endif
        {{-- @if ($credentialsLine)
          <p>{{ $credentialsLine }}</p>
        @endif --}}
      </div>
    @endif
  </section>

  <section class="contact" id="contact">
    <div data-enter>
      <header>
        @if ($contactEyebrow)
          <p>{{ $contactEyebrow }}</p>
        @endif
        <h2>{{ $contactTitle }}</h2>
      </header>
      @if ($contactIntro)
        <p>{!! $contactIntro !!}</p>
      @endif
      <p>
        @if ($phone)
          <a href="{{ $phoneHref }}">{{ $phone }}</a><br>
        @endif
        @if ($email)
          <a href="mailto:{{ $email }}">{{ $email }}</a>
        @endif
      </p>
      @if ($contactCtaLabel && $email)
        <a href="mailto:{{ $email }}">{{ $contactCtaLabel }}</a>
      @endif
    </div>
    <div aria-hidden="true">
      <div
        data-map
        @if ($mapboxToken) data-token="{{ $mapboxToken }}" @endif
        @if ($mapboxStyle) data-style="{{ $mapboxStyle }}" @endif
      ></div>
    </div>
  </section>
@endsection
