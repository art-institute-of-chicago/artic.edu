<video
    src="{{ $video['src'] ?? '' }}"
    poster="{{ $video['poster'] ?? '' }}"
    {{ isset($autoplay) ? ' autoplay' : '' }}
    {{ isset($loop) ? ' loop' : '' }}
    {{ isset($muted) ? ' muted' : '' }}
    {{ isset($preload) ? ' preload' : '' }}
    {{ isset($controls) ? ' controls="'.$controls.'"' : '' }}
></video>
