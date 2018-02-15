import { purgeProperties, escapeString, copyTextToClipboard, forEach, triggerCustomEvent } from '@area17/a17-helpers';

const shareMenu = function(container) {

  let socialWindowRef;
  let networks = [];
  let shareUrl;
  let shareTitle;

  function _pageUrl() {
    return escapeString(shareUrl);
  }

  function _pageTitle() {
    return escapeString(shareTitle);
  }

  function _openWindow(href, options) {
    if(!options) {
      options = {};
    }

    let width  = options.width || 575;
    let height = options.height || 400;
    let left   = (window.outerWidth  - width)  / 2;
    let top    = (window.outerHeight - height) / 2;
    let opts   = 'status=1' + ',width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;

    if (socialWindowRef && !socialWindowRef.closed) {
      socialWindowRef.close();
    }

    setTimeout(function() {
      socialWindowRef = window.open(href, 'AIC_Share', opts);
      socialWindowRef.opener = null;
    }, 250);
  }

  function _copyLink() {
    copyTextToClipboard(shareUrl, 'Copied!');
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    event.target.blur();
    let networkClicked = event.target.getAttribute('data-shareMenu');
    if (networkClicked === 'copy') {
      _copyLink();
    } else {
      forEach(networks, function(index, network) {
        if (network.name === networkClicked) {
          _openWindow(event.target.href, network.windowOptions);
        }
      });
    }
    triggerCustomEvent(document, 'shareMenu:close');
  }

  function _populateLinks(event) {
    shareUrl = window.location.href;
    shareTitle = document.title;

    if (event && event.data) {
      shareUrl = event.data.url || window.location.href;
      shareTitle = event.data.title || document.title;
    }

    forEach(networks, function(index, network) {
      let link = container.querySelector('[data-shareMenu='+network.name+']');
      if (link) {
        link.href = network.href();
        link.setAttribute('target','_blank');
      }
    });
  }

  function _init() {
    networks.push({
      name: 'facebook',
      href: function() {
        return 'https://www.facebook.com/sharer/sharer.php?u=' + _pageUrl();
      },
      windowOptions: {},
    });

    networks.push({
      name: 'twitter',
      href: function() {
        return 'https://twitter.com/intent/tweet?url=' + _pageUrl() + '&text=' + _pageTitle() + (container.getAttribute('data-share-twitter-via') ? '&via=' + container.getAttribute('data-share-twitter-via') : '');
      },
      windowOptions: {
        height: 253,
      },
    });

    networks.push({
      name: 'google',
      href: function() {
        return 'https://plus.google.com/share?url=' + _pageUrl();
      },
      windowOptions: {
        width: 515,
        height: 505,
      },
    });

    networks.push({
      name: 'pinterest',
      href: function() {
        return 'http://pinterest.com/pin/create/button/?url=' + _pageUrl() + '&media=' + escapeString(document.getElementsByTagName('img')[0].getAttribute('src') || '') + '&description=' + _pageTitle();
      },
      windowOptions: {
        width: 750,
        height: 675,
      },
    });

    networks.push({
      name: 'email',
      href: function() {
        return 'mailto:?Subject=' + _pageTitle() + '&Body=' + escapeString() + '\n\n' + _pageUrl() + '\n\n';
      },
      windowOptions: {},
    });

    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('shareMenu:opened', _populateLinks, false);
    _populateLinks();
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('shareMenu:opened', _populateLinks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default shareMenu;
