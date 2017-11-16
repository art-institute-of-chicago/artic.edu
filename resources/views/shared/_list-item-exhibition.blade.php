@php
$feature = isset($feature) ? $feature : false;
$hero = isset($hero) ? $hero : false;
@endphp
<{{ $tag or 'li' }} class="m-listing{{ $feature ? " m-listing--feature" : "" }}{{ ($feature and $hero) ? " o-features__hero-100vw" : "" }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img">
      <img src="{{ $exhibition->image['src'] }}">
    </span>
    <span class="m-listing__meta">
      <span class="m-listing__meta-top">
        <em class="type f-tag">{{ $exhibition->type }}</em>
        @if ($exhibition->closingSoon)
        <span class="type f-tag">Closing Soon</span>
        @endif
        @if ($feature and $hero)
        <span class="date f-secondary">{{ $exhibition->dateStart }} - {{ $exhibition->dateEnd }}</span>
        @endif
      </span><br>
      @if ($feature and $hero)
      <strong class="title f-display-1">{{ $exhibition->title }}</strong>
      @elseif ($feature)
      <strong class="title f-module-title-1">{{ $exhibition->title }}</strong>
      @else
      <strong class="title f-list-2">{{ $exhibition->title }}</strong>
      @endif
      @if (!$feature)
      <br><span class="m-listing__meta-bottom">
        <span class="date f-secondary">Through {{ $exhibition->dateEnd }}</span>
      </span>
      @endif
    </span>
  </a>
</{{ $tag or 'li' }}>
