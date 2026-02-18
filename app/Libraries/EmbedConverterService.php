<?php

namespace App\Libraries;

use DOMDocument;

class EmbedConverterService
{
    private const YOUTUBE_DEFAULT_TAG = 'iframe';
    private const YOUTUBE_DEFAULT_ATTRIBUTES = [
        'type' => 'text/html',
        'src' => null,
        'frameborder' => 0,
        'allow' => 'autoplay; encrypted-media',
        'allowfullscreen' => true,
        'referrerpolicy' => 'strict-origin-when-cross-origin',
    ];
    private const YOUTUBE_DEFAULT_PARAMETERS = [
        'enablejsapi' => true,
    ];

    public function convertUrl($url)
    {
        if (!empty($url)) {
            $parts = parse_url($url);

            if (isset($parts['host'])) {
                if (stripos($parts['host'], 'youtu') !== false) {
                    return $this->createYouTubeEmbed(attributes: ['src' => $url]);
                }

                if (stripos($parts['host'], 'vimeo') !== false) {
                    return $this->getVimeoEmbedCode($url);
                }

                if (stripos($parts['host'], 'soundcloud') !== false) {
                    return $this->getSoundCloudEmbedCode($url);
                }

                if (stripos($parts['host'], 'query.daap.bannerrepeater.org') !== false) {
                    return $this->getWikidataEmbedCode($url);
                }
            }
        }

        return '';
    }

    /**
     * Dynamically construct a YouTube embed code.
     *
     * Returns an HTML string.
     */
    public function createYouTubeEmbed(
        string $tag = self::YOUTUBE_DEFAULT_TAG,
        array $attributes = [],
        array $parameters = [],
    ): string {
        $document = new DOMDocument('1.0', 'UTF-8');
        $element = $document->createElement($tag);

        $attributes = array_merge(self::YOUTUBE_DEFAULT_ATTRIBUTES, $attributes);
        if ($attributes['src']) {
            $parameters = array_merge(self::YOUTUBE_DEFAULT_PARAMETERS, $parameters);
            if (!isset($parameters['origin'])) {
                $parameters['origin'] = config('app.url');
            }
            $attributes['src'] .= (str($attributes['src'])->contains('?') ? '&' : '?') . http_build_query($parameters);
        }
        foreach ($attributes as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $document->saveHTML($element);
    }

    public function getYoutubeThumbnailImage($url)
    {
        if ($id = $this->getYouTubeIdCode($url)) {
            return 'https://img.youtube.com/vi/' . $id . '/mqdefault.jpg';
        }
    }

    /**
     * getYouTubeIDCode description
     * @param  string $url YouTube video url, eg: https://www.youtube.com/watch?v=SZFVhIji7sY
     * @return string youtube ID
     */
    private function getYouTubeIdCode($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

        return $match[1] ?? null;
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
     * getWikidataEmbedCode description
     * @param  string $url Wikidata embed url, eg: https://query.daap.bannerrepeater.org/embed.html#...
     * @return string html code to embed in page
     */
    private function getWikidataEmbedCode($url)
    {
        return '<iframe src="' . $url . '" frameborder="0" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>';
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
            $videoId = substr($url, 10, strlen($url));
        }

        return '<iframe src="https://player.vimeo.com/video/' . $videoId . '?title=0&byline=0&portrait=0" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    }
}
