<?php

namespace App\Models\Scopes;

use App\Enums\ArticleStatusEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ArticleGlobalScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user != null) {
            if ($user->hasRole(RolesEnum::User->value)) {
                $builder->where('user_id', $user->id);
            }
        }else{
            $builder->where('status',ArticleStatusEnum::Approved->value);
        }
    }
}
