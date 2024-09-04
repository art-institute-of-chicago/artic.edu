<?php

namespace App\Enums;

enum DigitalPublicationArticleCategory: string
{
    case About = 'about';
    case Contributions = 'text';
    case Entry = 'entry';
    case Grouping = 'grouping';
    case Works = 'work';
}
