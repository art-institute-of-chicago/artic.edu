import { ajaxRequest } from '@area17/a17-helpers';

// The homepage is served from Cloudflare's edge cache without a Set-Cookie
// header, so a visitor landing on `/` may have no session/XSRF-TOKEN cookie
// yet, and the csrf-token meta tag baked into that cached HTML is stale.
// Fetch a live token to establish a session and refresh the meta tag.
const refreshCsrfToken = function() {
  if (document.cookie.indexOf('XSRF-TOKEN=') !== -1) {
    return;
  }

  ajaxRequest({
    url: '/ajaxData?q=csrfToken',
    type: 'GET',
    onSuccess(data) {
      try {
        data = JSON.parse(data);
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && data.token) {
          meta.setAttribute('content', data.token);
        }
      } catch (err) {
        console.error('Error refreshing CSRF token', err);
      }
    }
  });
};

export default refreshCsrfToken;
