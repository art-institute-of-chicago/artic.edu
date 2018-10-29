{{-- Preview dates --}}
@if ((!empty($previewDateStart) and $previewDateStart->gte(\Carbon\Carbon::today())) or (!empty($previewDateEnd) and $previewDateEnd->gte(\Carbon\Carbon::today())))
  @if (empty($previewDateStart) and empty($previewDateEnd))
  @elseif (empty($previewDateEnd) and !empty($previewDateStart))
    @component('components.atoms._date')
      @slot('tag','p')
      @slot('variation','f-previewdate')
      Member preview: <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j, Y') }}</time>
    @endcomponent
  @elseif (empty($previewDateStart))
  @elseif ($previewDateStart and $previewDateEnd)
    @component('components.atoms._date')
      @slot('tag','p')
      @slot('variation','f-previewdate')
      Member previews:
      @if($previewDateStart->format("Y") == $previewDateEnd->format("Y"))
        @if($previewDateStart->format("M") == $previewDateEnd->format("M"))
          <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('j, Y') }}</time>
        @else
          <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('M j, Y') }}</time>
        @endif
      @else
        <time datetime="{{ $previewDateStart->format("Y-m-d") }}">{{ $previewDateStart->format('M j, Y') }}</time>&ndash;<time datetime="{{ $previewDateEnd->format("Y-m-d") }}">{{ $previewDateEnd->format('M j, Y') }}</time>
      @endif
    @endcomponent
  @endif
@endif
