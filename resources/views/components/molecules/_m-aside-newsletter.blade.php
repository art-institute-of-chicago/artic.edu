@php
    $rand = rand(1, 1000);
@endphp
<form class="m-aside-newsletter{{ (isset($variation)) ? ' '.$variation : ' ' }}{{ (isset($error) and $error) ? ' s-error' : '' }}{{ (isset($success) and $success) ? ' s-success' : '' }}" action="/subscribe" data-behavior="newsletter" novalidate>
    <fieldset>
        <legend><h2 class="title f-list-3">{{ $copy ?? 'Sign up for our enewsletter to receive updates.' }}</h2></legend>
        <div class="m-aside-newsletter__field__wrapper">
            <span class="m-aside-newsletter__field">
                <label for="email{{ $rand }}" class="f-secondary">Email address</label>
                {{ csrf_field() }}
                <input type="email" name="email" id="email{{ $rand }}" class="f-secondary" placeholder="{{ $placeholder ?? '' }}">
                <button type="submit" class="{{ $btnFont ?? 'f-buttons' }} m-aside-newsletter__btn--submit" data-gtm-event-category="subscribe" data-gtm-event-action="{{$seo->title}}" data-gtm-event="email">Subscribe</button>
            </span>

            {{-- Do not show for newsletter block module --}}
            @if (isset($variation) && strpos($variation, 'm-aside-newsletter--wide') !== false)

            <div class="m-aside-newsletter__btn--list__wrapper">
                <button type="button" class="f-buttons m-aside-newsletter__btn--list">
                    See all newsletters
                    <svg class="icon--arrow">
                        <use xlink:href="#icon--arrow"></use>
                    </svg>
                </button>
            </div>

            <div class="m-aside-newsletter__list-wrapper" aria-hidden="true">
                <div class="m-aside-newsletter__list">
                    @php
                        $list = App\Models\ExactTargetList::getList();
                        $left = $list->slice(0, floor($list->count() / 2));
                        $right = $list->slice(floor($list->count() / 2));
                        $i = 0;
                    @endphp

                    <div class="m-aside-newsletter__list__left">
                        <ol class="m-fieldset__fields">
                          <li class="m-fieldset__field o-blocks m-fieldset__field--group">
                          @foreach($left as $value => $label)
                              @component('components.atoms._checkbox')
                                  @slot('checked', $value === 'OptEnews' ? 'checked' : null)
                                  @slot('disabled', $value === 'OptEnews' ? 'disabled' : null)
                                  @slot('id', 'subscriptions-' . $value)
                                  @slot('value', $value)
                                  @slot('name', 'subscriptions[' .$i .']')
                                  @slot('label', $label)
                              @endcomponent
                              @php $i++; @endphp
                          @endforeach
                          </li>
                        </ol>
                    </div>
                    <div class="m-aside-newsletter__list__right">
                        <ol class="m-fieldset__fields">
                          <li class="m-fieldset__field o-blocks m-fieldset__field--group">
                          @foreach($right as $value => $label)
                              @component('components.atoms._checkbox')
                                  @slot('id', 'subscriptions-' . $value)
                                  @slot('value', $value)
                                  @slot('name', 'subscriptions[' .$i .']')
                                  @slot('label', $label)
                              @endcomponent
                              @php $i++; @endphp
                          @endforeach
                          </li>
                        </ol>
                    </div>

                </div>
            </div>

            {{-- Only show for newsletter block module --}}
            @elseif (isset($variation) && strpos($variation, 'm-aside-newsletter--inline') !== false)

            <div class="m-aside-newsletter__also" aria-hidden="true">
                <span class="f-secondary">Includes news and exhibition announcements from the Art Institute of Chicago.</span>
            </div>
            <input type="hidden" name="subscriptions[]" id="subscriptions-{{ $list }}" value="{{ $list }}">

            @endif
        </div>
        @if (isset($error) and $error)
        <em class="m-aside-newsletter__msg m-aside-newsletter__msg--error f-buttons">{{ $error }}</em>
        @endif
        @if (isset($success) and $success)
        <em class="m-aside-newsletter__msg m-aside-newsletter__msg--success f-buttons">{{ $success }}</em>
        @endif

    </fieldset>
</form>
