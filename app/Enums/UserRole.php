<?php

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case Publisher = 2;
    case XDPublisher = 3;
    case Guest = 4;
}
