<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;

class CommentPolicy
{


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::CommentOnArticle->value);
    }

}
