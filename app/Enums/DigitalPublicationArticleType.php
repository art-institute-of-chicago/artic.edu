<?php

namespace App\Enums;

enum DigitalPublicationArticleType: string
{
    case About = 'about';
    case Contributions = 'text';
    case Entry = 'entry';
    case Grouping = 'grouping';
    case Works = 'work';
}
