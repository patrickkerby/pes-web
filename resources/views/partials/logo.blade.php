@php
  $name = $item['name'] ?? '';
  $href = $item['url'] ?? '';
  $note = $item['note'] ?? '';
  $logo = $item['logo'] ?? null;
  $src = is_array($logo) ? ($logo['url'] ?? '') : (is_object($logo) ? (string) ($logo->url ?? '') : '');
  $alt = is_array($logo) ? ($logo['alt'] ?? '') : (is_object($logo) ? (string) ($logo->alt ?? '') : '');
  $alt = $alt !== '' ? $alt : $name;
  $tag = $href ? 'a' : 'div';
@endphp
@if ($src || $name)
  <{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    @if ($name) aria-label="{{ $name }}" @endif
    @if ($note) title="{{ $note }}" @endif
  >@if ($src)<img src="{{ $src }}" alt="{{ $alt }}">@elseif ($name)<span>{{ $name }}</span>@endif</{{ $tag }}>
@endif
