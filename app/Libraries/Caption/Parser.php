<?php

namespace App\Libraries\Caption;

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
     * Construct the transcript by collating the lines from each caption.
     */
    public function getTranscript(): string
    {
        $transcript = collect($this->captions)
            ->reduce( // Collect all lines in one array
                fn ($allLines, $caption) => $allLines->concat($caption->lines),
                collect(),
            )
            ->map( // Iterate thru array of lines
                fn ($line) => str($line)->whenStartsWith(
                    '- ',
                    fn ($line) => $line->replace('- ', "\n"),
                )
            )
            ->join(' '); // Join each line with a space

        return $transcript;
    }

    /**
     * The file format is determined by examining the first line.
     */
    private static function getParser(string $file): ?string
    {
        $parser = null;
        $firstLinePatterns = collect([SubRipParser::INDEX, SubViewerParser::INTERVAL])->join('|');
        $firstLine = current(explode("\n", $file));
        preg_match("/$firstLinePatterns/", $firstLine, $matches);
        if ($matches['index'] ?? false) {
            $parser = SubRipParser::class;
        } elseif ($matches['interval'] ?? false) {
            $parser = SubViewerParser::class;
        }

        return $parser;
    }
}
