<?php

namespace Tests\Feature;

use App\Enums\ArticleStatusEnum;
use App\Enums\RolesEnum;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserArticleTest extends BaseTestCase
{
    public function test_create_new_article()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::User->value);
        $url = "api/articles";

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson($url, [
                'title' => "This is a test title",
                'content' => "This is a test content"
            ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'id' => $response['data']['id'],
        ]);
        $response->assertJson([
            'data' => [
                'user_id' => $user->id
            ]
        ]);
    }

    public function test_update_article()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::User->value);
        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);
        $url = "api/articles/$article->id";

        $updatedArticle = [
            'title' => "This is a test title",
            'content' => "This is a test content",
            '_method' => "put"
        ];
        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson($url, $updatedArticle);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $updatedArticle['title'],
            'content' => $updatedArticle['content'],
            'status' => ArticleStatusEnum::Updated->value
        ]);
        $response->assertJson([
            'data' => [
                'title' => $updatedArticle['title'],
                'content' => $updatedArticle['content'],
                'status' => ArticleStatusEnum::Updated->value
            ]
        ]);
    }

    public function test_destroy_article()
    {
        $user = User::factory()->create()->assignRole(RolesEnum::User->value);
        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id
        ]);

        $url = "api/articles/$article->id";

        $response = $this
            ->actingAs($user, 'sanctum')
            ->deleteJson($url);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id
        ]);
        $this->assertDatabaseMissing('comments', [
            'article_id' => $article->id
        ]);

    }
}
