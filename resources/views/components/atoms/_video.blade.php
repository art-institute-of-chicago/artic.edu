<video
    data-src="{{ $video['src'] ?? '' }}"
    poster="{{ aic_makePosterSrc($video['poster']) ?? '' }}"
    {{ isset($autoplay) ? ' autoplay' : '' }}
    {{ isset($loop) ? ' loop' : '' }}
    {{ isset($muted) ? ' muted' : '' }}
    {{ isset($preload) ? ' preload' : '' }}
    {{ isset($controls) ? ' controls="'.$controls.'"' : '' }}
></video>
