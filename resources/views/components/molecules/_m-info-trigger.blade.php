@php
    $variation = ($isInverted ?? false) ? 'm-info-trigger--inverse' : '';
    $iconClass = ($isInverted ?? false) ? 'icon--info' : 'icon--info-i';
@endphp
@if (!empty($creditUrl))
    <a href="{{ $creditUrl }}" class="m-info-trigger {{ $variation }}">
        <svg class="{{ $iconClass }}" aria-label="Image credit"><use xlink:href="#{{ $iconClass }}" /></svg>
    </a>
@elseif (!empty($creditText))
    <button class="m-info-trigger {{ $variation }}" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
      <svg class="{{ $iconClass }}" aria-label="Image credit"><use xlink:href="#{{ $iconClass }}" /></svg>
    </button>
    <div class="m-info-trigger__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
      <div class="f-caption">{!! $creditText !!}</div>
    </div>
@endif
