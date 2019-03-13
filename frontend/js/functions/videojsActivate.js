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

  function _registerTranscriptButton() {
    var vjsButtonComponent = window.videojs.getComponent('Button');

    window.videojs.registerComponent('TranscriptButton', videojs.extend(vjsButtonComponent, {
      constructor: function () {
        vjsButtonComponent.apply(this, arguments);
        this.controlText('Download transcript');
      },
      handleClick: function () {
        window.open(this.player_.el_.getAttribute('data-transcript-uri'), '_blank');
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

      if (audios[i].hasAttribute('data-transcript-uri')) {
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
