import { triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';

const videojsActivate = function() {

  // https://stackoverflow.com/questions/39121463/videojs-5-plugin-add-button
  function _registerDownloadButton() {
    var vjsButtonComponent = window.videojs.getComponent('Button');

    window.videojs.registerComponent('DownloadButton', videojs.extend(vjsButtonComponent, {
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
    var vjsButtonComponent = window.videojs.getComponent('Button');

    window.videojs.registerComponent('TranscriptButton', videojs.extend(vjsButtonComponent, {
      constructor: function () {
        vjsButtonComponent.apply(this, arguments);
        this.controlText('Toggle transcript');
      },
      handleClick: function () {
        let listingElement = _findAncestor(this.player_.el_,'m-listing--sound');
        let buttonElement = listingElement.querySelector('.vjs-transcript-button');
        let target = listingElement.querySelector('.m-listing--sound__transcript');

        if (target.getAttribute('aria-hidden') === 'true') {
          // open
          target.style.height = 0;
          target.style.overflow = 'hidden';
          target.setAttribute('aria-hidden', 'false');
          setTimeout(function(){ setTimeout(function(){ setFocusOnTarget(target); }, 0) }, 0)
          _getHeightAndSet(target);
          buttonElement.classList.add('vjs-transcript-button--opened');
        } else {
          // close
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

    for (var i=0, max=audios.length; i < max; i++) {

      var children = [
        "PlayToggle",
        "CurrentTimeDisplay",
        "TimeDivider",
        "DurationDisplay",
        "ProgressControl",
        "MuteToggle",
        "VolumeControl",
      ];

      if (audios[i].hasAttribute('data-has-transcript')) {
        children.push("TranscriptButton")
      }

      if (audios[i].hasAttribute('data-is-downloadable')) {
        children.push("DownloadButton")
      }

      children.push("LiveDisplay")

      window.videojs( audios[i], {
        "children": [
          "MediaLoader",
          // "PosterImage",
          // "TextTrackDisplay",
          // "LoadingSpinner",
          // "BigPlayButton",
          {
            "name": "controlBar",
            "children": children,
          },
          "ErrorDisplay",
          // "TextTrackSettings",
          "ResizeManager"
        ]
      });
    }
  }

  document.addEventListener('ajaxPageLoad:complete', _activateAudioPlayers, false);

  _registerDownloadButton();
  _registerTranscriptButton();
  _activateAudioPlayers();
}

export default videojsActivate;
