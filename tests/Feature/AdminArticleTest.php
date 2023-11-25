<?php

namespace Tests\Feature;

use App\Enums\ArticleStatusEnum;
use App\Enums\RolesEnum;
use App\Models\Article;
use App\Models\User;

class AdminArticleTest extends BaseTestCase
{
    public function test_review_article()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::Admin->value);
        $article = Article::factory()->create();
        $url = "api/articles/$article->id/review";

        $response = $this
            ->actingAs($user, 'sanctum')
            ->getJson($url);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => ArticleStatusEnum::Reviewed->value,
            'reviewed_by' => $user->id
        ]);
        $response->assertJson([
            'data' => [
                'status' => ArticleStatusEnum::Reviewed->value,
                'reviewed_by' => $user->id
            ]
        ]);
    }

    public function test_approve_article()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::Admin->value);
        $article = Article::factory()->create();
        $url = "api/articles/$article->id/approve";

        $response = $this
            ->actingAs($user, 'sanctum')
            ->getJson($url);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'status' => ArticleStatusEnum::Approved->value,
            'approved_by' => $user->id
        ]);
        $response->assertJson([
            'data' => [
                'status' => ArticleStatusEnum::Approved->value,
                'approved_by' => $user->id
            ]
        ]);
    }
}
