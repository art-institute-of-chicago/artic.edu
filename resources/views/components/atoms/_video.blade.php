<video
    data-src="{{ $video['src'] ?? '' }}"
    poster="{{ (isset($video['poster']) ? ImageHelpers::aic_makePosterSrc($video['poster']) : '') ?? '' }}"
    title="{{ $video['title'] ?? $video['alt'] ?? $title ?? '' }}"
    class="{{ $class ?? '' }}"
    {{ isset($autoplay) ? ' autoplay' : '' }}
    {{ isset($loop) && $loop ? ' loop' : '' }}
    {{ isset($muted) ? ' muted' : '' }}
    {{ isset($playsinline) ? ' playsinline=playsinline' : '' }}
    {{ isset($preload) ? ' preload' : '' }}
    {{ isset($controls) && $controls ? ' controls' : '' }}
></video>
