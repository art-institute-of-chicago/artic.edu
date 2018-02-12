<form class="m-aside-newsletter{{ (isset($variation)) ? ' '.$variation : ' ' }}{{ (isset($error) and $error) ? ' s-error' : '' }}{{ (isset($success) and $success) ? ' s-success' : '' }}" action="/subscribe" data-behavior="newsletter">
  <fieldset>
    <legend><span class="title f-list-3">Sign up to our newsletter and receive updates.</span></legend>
    <span class="m-aside-newsletter__field">
      <label for="email" class="f-secondary">Email address</label>
      <input type="text" name="email" class="f-secondary" placeholder="{{ $placeholder ?? '' }}">
      <button type="submit" class="{{ $btnFont ?? 'f-buttons' }}">Sign Up</button>
    </span>
    @if (isset($error) and $error)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--error f-buttons">{{ $error }}</em>
    @endif
    @if (isset($success) and $success)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--success f-buttons">{{ $success }}</em>
    @endif
  </fieldset>
</form>
