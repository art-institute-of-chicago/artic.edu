<?php

namespace App\Libraries;

use Cache;

class EmbedConverterService
{
    public function __construct()
    {
    }

    public function convertUrl($url)
    {
        if (!empty($url)) {
            $parts = parse_url($url);
            if (isset($parts['host'])) {
                if (stripos($parts['host'], 'youtube') !== false) {
                    return $this->getYouTubeEmbedCode($url);
                } elseif (stripos($parts['host'], 'vimeo') !== false) {
                    return $this->getVimeoEmbedCode($url);
                } elseif (stripos($parts['host'], 'soundcloud') !== false) {
                    return $this->getSoundCloudEmbedCode($url);
                }
            }
        }

        return '';
    }

    /**
     * getYouTubeEmbedCode description
     * @param  string $url YouTube video url, eg: https://www.youtube.com/watch?v=SZFVhIji7sY
     * @return [type]      [description]
     */
    private function getYouTubeEmbedCode($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $videoId = $match[1];
        return '<iframe src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    }

    /**
     * [getSoundCloudEmbedCode description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    private function getSoundCloudEmbedCode($url)
    {
        return $url;
    }

    /**
     * [getVimeoEmbedCode description]
     * @param  [type] $url [description] eg: https://vimeo.com/182466118
     * @return [type]      [description]
     */
    private function getVimeoEmbedCode($url)
    {

        if (preg_match('~^http[s]://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $url, $match)) {
            $videoId = $match[1];
        } else {
            $videoId = substr($url,10,strlen($url));
        }

        return '<iframe src="https://player.vimeo.com/video/'.$videoId.'?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    }
}
