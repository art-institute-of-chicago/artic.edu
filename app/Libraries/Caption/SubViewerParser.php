<?php

namespace App\Libraries\Caption;

class SubViewerParser extends Parser
{
    public const EXTENSION = 'sbv';
    public const TIMESTAMP = '(\d+:\d{2}:\d{2}.\d{3})';
    public const INTERVAL = '^(?P<interval>' . self::TIMESTAMP . ',' . self::TIMESTAMP . ')$';
    public const LINE = '^(?P<line>.*)$';

    private const PATTERNS = [
        self::INTERVAL,
        self::LINE,
    ];

    protected function parseCaptions(): void
    {
        $patterns = collect(self::PATTERNS)->join('|');
        foreach (explode("\n", $this->text) as $line) {
            preg_match("/$patterns/", $line, $matches);
            if ($matches['interval']) {
                $caption = new \stdClass();
                $caption->start = $matches[2];
                $caption->end = $matches[3];
                $this->captions[] = $caption;
                $latest = array_key_last($this->captions);
            } elseif ($line = $matches['line']) {
                $caption = $this->captions[array_key_last($this->captions)];
                $caption->lines[] = $line;
            }
        }
    }
}
