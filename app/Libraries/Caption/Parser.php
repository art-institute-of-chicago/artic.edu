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
        return collect($this->captions)
            ->chunkWhile(function ($caption) {
                // Chunk captions into paragraphs
                $firstLine = str(collect($caption->lines)->first());
                return !$firstLine->startsWith('-');
            })
            ->flatMap(function ($paragraph, $paragraphIndex) use ($video) {
                return $paragraph->chunkWhile(function ($caption, $index, $chunk) {
                    // Chunk paragraph into sentences
                    $previousChunk = $chunk->last();
                    $previousLine = str(collect($previousChunk->lines)->last());
                    return !$previousLine->endsWith('.');
                })
                ->chunk(3)->map(function ($sentences, $sentenceIndex) use ($paragraphIndex, $video) {
                    // Chunk into three sentences
                    $captionsForParagraph = $sentences->flatten();
                    return <<<HTML
                        <div id="caption-{$paragraphIndex}-{$sentenceIndex}" class="caption">
                            {$this->getTimestamp($captionsForParagraph->first(), $video)}
                            {$this->getParagraph($captionsForParagraph)}
                        </div>
                    HTML;
                });
            })
            ->join('');
    }

    /**
     *  Create a timestamp link for the caption.
     */
    protected function getTimestamp($caption, $video): string
    {
        $timestamp = str($caption->start)->split('/[,.]/')->first();
        $seconds = str($timestamp)
            ->explode(':')
            ->map(fn ($part, $index) => (int) $part * (60 ** (2 - $index)))
            ->sum();
        $url = ($video->url ?? '/') . '?transcript=true&start=' . $seconds;

        return <<<HTML
            <a
                class="timestamp"
                href="#"
                data-behavior="controlYoutubeEmbed"
                data-embed-id="$video->youtube_id"
                data-seek-to="$seconds"
                data-play-video
            >
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
