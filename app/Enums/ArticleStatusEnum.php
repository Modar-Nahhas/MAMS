<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ArticleStatusEnum: string
{
    use EnumToArray;

    case Pending = 'pending';
    case Reviewed = 'reviewed';
    case Approved = 'approved';
}
