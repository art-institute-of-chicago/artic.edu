<div class="m-intro-block">
  <p class="f-deck">{{ $intro }}</p>
  @if ((isset($primaryActions) and $primaryActions) or (isset($secondaryActions) and $secondaryActions))
  <div class="m-intro-block__footer">
    @if ($primaryActions)
    <ul class="m-intro-block__footer-actions-primary">
      @foreach ($primaryActions as $link)
      <li><a href="{{ $link['href'] }}" class="btn">{{ $link['text'] }}</a></li>
      @endforeach
    </ul>
    @endif
    @if ($secondaryActions)
    <ul class="m-intro-block__footer-actions-secondary">
      @foreach ($secondaryActions as $link)
      <li><a href="{{ $link['href'] }}">{{ $link['text'] }}<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
      @endforeach
    </ul>
    @endif
  </div>
  @endif
</div>
