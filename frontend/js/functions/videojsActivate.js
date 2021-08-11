import { triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import videojs from 'video.js';
import eventTracking from 'videojs-event-tracking';

const videojsActivate = function() {
  // WEB-2216: Not sure why, but this code doesn't work in our fork
  if (typeof videojs.getPlugin('eventTracking') === 'undefined') {
    videojs.registerPlugin('eventTracking', eventTracking);
  }

  // @see https://stackoverflow.com/questions/39121463/videojs-5-plugin-add-button
  function _registerDownloadButton() {
    var vjsButtonComponent = videojs.getComponent('Button');

    videojs.registerComponent('DownloadButton', videojs.extend(vjsButtonComponent, {
      constructor: function () {
        vjsButtonComponent.apply(this, arguments);
        this.controlText('Download audio');
      },
      handleClick: function () {
        window.open(this.player_.cache_.src);
      },
      buildCSSClass: function () {
        return 'vjs-control vjs-custom-button vjs-download-button';
      },
    }));
  }

  function _findAncestor(el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
  }

  function _getHeightAndSet(target) {
    let targetHeight = target.firstElementChild.offsetHeight;
    target.style.height = targetHeight + 'px';
  }

  function _unsetAfterAnimation() {
    this.removeAttribute('style');
    this.removeEventListener('transitionend', _unsetAfterAnimation);
    triggerCustomEvent(document, 'page:updated');
  }

  function _registerTranscriptButton() {
    var vjsButtonComponent = videojs.getComponent('Button');

    videojs.registerComponent('TranscriptButton', videojs.extend(vjsButtonComponent, {
      constructor: function () {
        vjsButtonComponent.apply(this, arguments);
        this.controlText('Toggle transcript');
      },
      handleClick: function () {
        let listingElement = _findAncestor(this.player_.el_,'m-listing--sound');
        let buttonElement = listingElement.querySelector('.vjs-transcript-button');
        let target = listingElement.querySelector('.m-listing--sound__transcript');

        if (target.getAttribute('aria-hidden') === 'true') {
          // Open
          target.style.height = 0;
          target.style.overflow = 'hidden';
          target.setAttribute('aria-hidden', 'false');
          setTimeout(function(){ setTimeout(function(){ setFocusOnTarget(target); }, 0) }, 0)
          _getHeightAndSet(target);
          buttonElement.classList.add('vjs-transcript-button--opened');
        } else {
          // Close
          _getHeightAndSet(target);
          target.setAttribute('aria-hidden', 'true');
          let thrash = target.offsetHeight;
          target.style.height = 0;
          target.style.overflow = 'hidden';
          buttonElement.classList.remove('vjs-transcript-button--opened');
        }

        target.addEventListener('transitionend', _unsetAfterAnimation, false);
      },
      buildCSSClass: function () {
        return 'vjs-control vjs-custom-button vjs-transcript-button';
      },
    }));
  }

  function _activateAudioPlayers() {
    var audios = document.getElementsByClassName('video-js')

    Array.from(audios).forEach(function(audio) {
      if (audio.hasAttribute('data-has-started')) {
        return;
      }

      audio.setAttribute('data-has-started', true);

      var children = [
        'PlayToggle',
        'CurrentTimeDisplay',
        'TimeDivider',
        'DurationDisplay',
        'ProgressControl',
        'MuteToggle',
        'VolumeControl',
      ];

      if (audio.hasAttribute('data-has-transcript')) {
        children.push('TranscriptButton')
      }

      if (audio.hasAttribute('data-is-downloadable')) {
        children.push('DownloadButton')
      }

      children.push('LiveDisplay')

      var player = videojs( audio, {
        children: [
          'MediaLoader',
          {
            name: 'controlBar',
            children: children,
          },
          'ErrorDisplay',
          'ResizeManager'
        ],
        plugins: {
          eventTracking: true,
        }
      });

      // e.g. audio-play vs. audio-tour-play
      var prefix = 'audio';

      if (audio.hasAttribute('data-gtm-prefix')) {
        prefix = audio.getAttribute('data-gtm-prefix')
      }

      var title = 'Untitled';

      if (audio.hasAttribute('data-gtm-title')) {
        title = audio.getAttribute('data-gtm-title')
      }

      function _log(suffix) {
        triggerCustomEvent(document, 'gtm:push', {
          'event': prefix + '-' + suffix,
          'eventCategory': 'audio-engagement',
          'action': title,
        });
      }

      player.on('tracking:firstplay', (e, data) => _log('play'));
      player.on('tracking:pause', (e, data) => _log('pause'));
      player.on('tracking:first-quarter', (e, data) => _log('25'));
      player.on('tracking:second-quarter', (e, data) => _log('50'));
      player.on('tracking:third-quarter', (e, data) => _log('75'));
      player.on('tracking:fourth-quarter', (e, data) => _log('100'));
    });
  }

  document.addEventListener('page:updated', _activateAudioPlayers, false);

  _registerDownloadButton();
  _registerTranscriptButton();
  _activateAudioPlayers();
}

export default videojsActivate;
