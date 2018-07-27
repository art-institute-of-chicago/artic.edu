<video
    data-src="{{ $video['src'] ?? '' }}"
    poster="{{ aic_makePosterSrc($video['poster']) ?? '' }}"
    title="{{ $video['title'] ?? $video['alt'] ?? $title ?? '' }}"
    {{ isset($autoplay) ? ' autoplay' : '' }}
    {{ isset($loop) ? ' loop' : '' }}
    {{ isset($muted) ? ' muted' : '' }}
    {{ isset($preload) ? ' preload' : '' }}
    {{ isset($controls) ? ' controls="'.$controls.'"' : '' }}
></video>
