<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum RolesEnum: string
{
    use EnumToArray;
    case Admin = 'admin';
    case User = 'user';
}
