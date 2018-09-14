<button class="info-button-trigger" data-behavior="infoButtonTrigger" aria-label="Info" aria-expanded="false" {!! (isset($id)) ? ' aria-labelledby="h-'.$id.'" data-tooltip-id="'.$id.'"' : '' !!}>
  <svg class="icon--info"><use xlink:href="#icon--info" /></svg>
</button>
<span class="info-button-info s-hidden" id="info-button-info-{{ $id ?? '' }}" data-behavior="infoButtonInfo">
    <span class="f-caption">{{ $slot ?? ''}}</span>
</span>
