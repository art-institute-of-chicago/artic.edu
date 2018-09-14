<button class="info-button-trigger" data-behavior="infoButtonTrigger" aria-label="Info" aria-expanded="false" {!! (isset($labelledBy)) ? ' aria-labelledby="'.$labelledBy.'"' : '' !!}>
  <svg class="icon--info"><use xlink:href="#icon--info" /></svg>
  <span class="s-hidden">{{ $slot ?? ''}}</span>
</button>
