<?php

namespace App\Libraries\Caption;

use App\Models\Video;

abstract class Parser
{
    public array $captions;

    protected string $text;

    abstract protected function parseCaptions();

    public function __construct(string $text = '')
    {
        $this->text = $text;
        $this->parseCaptions();
    }

    /**
     * Factory method for determining the correct parser based on file format.
     *
     * Return a parser object with the parsed file.
     *
     * Throws an exception if no parser could be determined.
     */
    public static function parseFile(string $file): Parser
    {
        if ($parser = self::getParser($file)) {
            return new $parser($file);
        } else {
            throw new \Exception('Unknown file format!');
        }
    }

    /**
     * Construct an HTML transcript for the given video by collating the lines
     * from each caption.
     */
    public function getTranscript(Video $video): string
    {
        $transcript = collect($this->captions)
            ->chunkWhile(fn ($caption) => isset($caption->lines[0]) && !str($caption->lines[0])->startsWith('- '))
            ->reduce( // Combine chunks into a single transcript
                fn ($html, $chunk, $index) => $html . <<<HTML
                    <div id="caption-{$index}" class="caption">
                        {$this->getTimestamp($chunk->first(), $video)}
                        {$this->getParagraph($chunk)}
                    </div>
                HTML,
                ''
            );
        return <<<HTML
            <div class="video-transcript">
                $transcript
            </div>
        HTML;
    }

    /**
     *  Create a timestamp link for the caption.
     */
    protected function getTimestamp($caption, $video): string
    {
        $timestamp = str($caption->start)->before(',');
        $seconds = $timestamp
            ->explode(':')
            ->map(fn ($part, $index) => (int) $part * (60 ** (2 - $index)))
            ->sum();

        return <<<HTML
            <a class="timestamp" href="{$video->video_url}&t={$seconds}">
                $timestamp
            </a>
        HTML;
    }

    /**
     * Create a paragraph from the caption lines.
     */
    protected function getParagraph($captions): string
    {
        $paragraph = collect($captions)
            ->flatMap(fn ($caption) => $caption->lines)
            ->implode(fn ($line) => str($line)->ltrim('- '), ' ');

        return <<<HTML
            <p>
                $paragraph
            </p>
        HTML;
    }

    /**
     * The file format is determined by examining the first line.
     */
    private static function getParser(string $file): ?string
    {
        $parser = null;
        $firstLinePatterns = collect([SubRipParser::INDEX, SubViewerParser::INTERVAL])->join('|');
        $firstLine = trim(current(explode("\n", $file)));
        preg_match("/$firstLinePatterns/", $firstLine, $matches);
        if ($matches['index'] ?? false) {
            $parser = SubRipParser::class;
        } elseif ($matches['interval'] ?? false) {
            $parser = SubViewerParser::class;
        }

        return $parser;
    }
}
