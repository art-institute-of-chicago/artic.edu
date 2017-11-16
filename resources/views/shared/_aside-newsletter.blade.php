<form class="m-aside-newsletter">
  <fieldset>
    <legend><span class="title f-deck">Sign up to our newsletter and receive updates.</span></legend>
    <span class="m-aside-newsletter__field">
      <label for="newsletterEmail">Email address</label>
      <input id="newsletterEmail" name="newsletterEmail" class="f-buttons" placeholder="Email address">
      <button type="submit" class="f-tag">Sign Up</button>
    </span>
    @if (isset($error) and $error)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--error f-buttons">Please enter a valid email address</em>
    @endif
    @if (isset($success) and $success)
    <em class="m-aside-newsletter__msg m-aside-newsletter__msg--success f-buttons">Successfully signed up to the newsletter</em>
    @endif
  </fieldset>
</form>
