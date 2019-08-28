import queryStringHandler from '@area17/a17-helpers';

/**
 * This is a modification of A17's `ajaxRequest` that allows us to detect redirects.
 *
 * To use it, replace this:
 *
 *   import { ajaxRequest } from '@area17/a17-helpers';
 *
 * ...with this:
 *
 *   import { ajaxRequestCustom } from '../functions';
 *
 * ...and replace calls to `ajaxRequest` with `ajaxRequestCustom`.
 *
 * Spec: https://xhr.spec.whatwg.org/#the-responseurl-attribute
 */
var ajaxRequestCustom = function(settings) {
  // Doc: https://code.area17.com/a17/a17-helpers/wikis/ajaxRequest

  var options = settings;
  var request = new XMLHttpRequest();
  var requestUrl = options.url;

  options.queryString = '';
  if (options.data !== undefined) {
    if (queryStringHandler.fromObject) {
      options.queryString = queryStringHandler.fromObject(options.data);
    } else {
      throw new ReferenceError('Missing: queryStringHandler.fromObject');
    }
  }

  if (options.type !== 'POST') {
    requestUrl += (requestUrl.indexOf('?') > 0) ? options.queryString.replace('?', '&') : options.queryString;
  }

  request.open(options.type, requestUrl, true);

  request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

  if (options.type === 'POST') {
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  }

  if (options.requestHeaders !== undefined && options.requestHeaders.length > 0) {
    for (var i = 0; i < options.requestHeaders.length; i++) {
      var header = options.requestHeaders[i].header;
      var value = options.requestHeaders[i].value;
      if (header !== undefined && value !== undefined) {
        request.setRequestHeader(header, value);
      }
    }
  }

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {

      // Success!
      if ((typeof options.onSuccess).toLowerCase() === 'function') {
        options.onSuccess.call(this, request.responseText, request.status, request.responseURL);
      }
    } else {
      if ((typeof options.onError).toLowerCase() === 'function') {
        options.onError.call(this, request.responseText, request.status, request.responseURL);
      }
      console.log('We reached our target server, but it returned an error: '+request.statusText);
    }
  };

  request.onerror = function() {
    console.log('There was a connection error of some sort');
    if ((typeof options.onError).toLowerCase() === 'function') {
      options.onError.call(this, request.responseText, request.status);
    }
  };

  request.send((options.type === 'POST') ? options.queryString.replace('?', '') : '');
};

export default ajaxRequestCustom;
