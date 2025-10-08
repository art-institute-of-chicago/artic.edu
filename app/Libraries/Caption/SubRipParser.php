<?php

namespace App\Libraries\Caption;

class SubRipParser extends Parser
{
    public const EXTENSION = 'srt';
    public const INDEX = '^(?P<index>\d+)$';
    public const TIMESTAMP = '(\d{2}:\d{2}:\d{2},\d{3})';
    public const INTERVAL = '^(?P<interval>' . self::TIMESTAMP . ' --> ' . self::TIMESTAMP . ')$';
    public const LINE = '^(?P<line>.*)$';

    private const PATTERNS = [
        self::INDEX,
        self::INTERVAL,
        self::LINE,
    ];

    protected function parseCaptions(): void
    {
        $patterns = collect(self::PATTERNS)->join('|');
        $lines = str($this->text)->explode("\r\n")->flatMap(fn ($text) => str($text)->explode("\n"));
        foreach ($lines as $line) {
            preg_match("/$patterns/", $line, $matches);
            if ($index = $matches['index']) {
                $caption = new \stdClass();
                $caption->index = $index;
                $this->captions[] = $caption;
            } elseif ($matches['interval']) {
                $caption = $this->captions[array_key_last($this->captions)];
                $caption->start = $matches[3];
                $caption->end = $matches[4];
            } elseif ($line = $matches['line']) {
                $caption = $this->captions[array_key_last($this->captions)];
                $caption->lines[] = $line;
            }
        }
    }
}
