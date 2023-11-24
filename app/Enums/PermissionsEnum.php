<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionsEnum:string
{
    use EnumToArray;

    case ViewArticle = 'view_article';
    case StoreArticle = 'store_article';
    case UpdateArticle = 'update_article';
    case DestroyArticle = 'destroy_article';
    case CommentOnArticle = 'comment_on_article';
    case ReviewArticle = 'review_article';
    case ApproveArticle = 'approve_article';

}
