<?php

namespace App\Observers;

use App\Enums\RolesEnum;
use App\Jobs\NewArticleEmailNotificationJob;
use App\Models\Article;
use App\Models\User;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        $adminUsersId = User::query()->whereHas('roles', function ($rolesQuery) {
            $rolesQuery->where('name', RolesEnum::Admin->name);
        })->pluck('email')->toArray();
        NewArticleEmailNotificationJob::dispatch($article->title, $adminUsersId);

    }
}
