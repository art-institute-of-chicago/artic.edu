@php
    $rand = rand(1, 1000);
@endphp
<form class="m-aside-newsletter{{ (isset($variation)) ? ' '.$variation : ' ' }}{{ (isset($error) and $error) ? ' s-error' : '' }}{{ (isset($success) and $success) ? ' s-success' : '' }}" action="/subscribe" data-behavior="newsletter" novalidate>
  <fieldset>
    <legend><h2 class="title f-list-3">Sign up to our newsletter and receive updates.</h2></legend>
    <span class="m-aside-newsletter__field">
      <label for="email{{ $rand }}" class="f-secondary">Email address</label>
      {{ csrf_field() }}
      @if (isset($list))
        <input type="hidden" name="list" id="list{{ $rand }}" value="{!! $list !!}">
      @endif
      <input type="email" name="email" id="email{{ $rand }}" class="f-secondary" placeholder="{{ $placeholder ?? '' }}">
      <button type="submit" class="{{ $btnFont ?? 'f-buttons' }}">Subscribe</button>
    </span>
    @if (isset($error) and $error)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--error f-buttons">{{ $error }}</em>
    @endif
    @if (isset($success) and $success)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--success f-buttons">{{ $success }}</em>
    @endif
  </fieldset>
</form>
