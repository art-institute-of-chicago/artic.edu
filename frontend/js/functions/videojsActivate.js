const videojsActivate = function() {

    // https://stackoverflow.com/questions/39121463/videojs-5-plugin-add-button
    var vjsButtonComponent = videojs.getComponent('Button');

    window.videojs.registerComponent('DownloadButton', videojs.extend(vjsButtonComponent, {
        constructor: function () {
            vjsButtonComponent.apply(this, arguments);
            this.controlText('Download audio');
        },
        handleClick: function () {
            window.open(this.player_.cache_.src);
        },
        buildCSSClass: function () {
            return 'vjs-control vjs-download-button';
        },
    }));

    // activate all .video-js elements
    var audios = document.getElementsByClassName('video-js')

    for (var i=0, max=audios.length; i < max; i++) {
        window.videojs( audios[i], {
            "children": [
                "MediaLoader",
                // "PosterImage",
                // "TextTrackDisplay",
                // "LoadingSpinner",
                // "BigPlayButton",
                {
                    "name": "controlBar",
                    "children": [
                        "PlayToggle",
                        "CurrentTimeDisplay",
                        "TimeDivider",
                        "DurationDisplay",
                        "ProgressControl",
                        "MuteToggle",
                        "VolumeControl",
                        "DownloadButton", // our addition
                        "LiveDisplay"
                    ]
                },
                "ErrorDisplay",
                // "TextTrackSettings",
                "ResizeManager"
            ]
        });
    }
}

export default videojsActivate;
