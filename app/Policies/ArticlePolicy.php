<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::ViewArticle->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::ViewArticle->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::StoreArticle->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::UpdateArticle->value) && $user->id == $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user != null && $user->hasRole(RolesEnum::Admin->value) || ($user->hasPermissionTo(PermissionsEnum::UpdateArticle->value) && $user->id == $article->user_id);
    }

    public function review(User $user): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::ReviewArticle->value);
    }

    public function approve(User $user): bool
    {
        return $user != null && $user->hasPermissionTo(PermissionsEnum::ReviewArticle->value);
    }

}
