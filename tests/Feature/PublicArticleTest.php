<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Testing\Fluent\AssertableJson;

class PublicArticleTest extends BaseTestCase
{
//    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_paginated_article_index_with_comments(): void
    {
        $page = 1;
        $number = 4;
        Article::factory($number)->create();
        $withComments = 1;

        $url = "/api/articles?page=$page&number=$number&with_comments=$withComments";
        $response = $this->getJson($url);
        $response->assertJson(function (AssertableJson $json) use ($number) {
            $json->hasAll(['data', 'message', 'status', 'code']);
        })->assertJsonCount($number, 'data.data')
            ->assertJsonStructure(['data' => [
                'data' => [
                    0 => [
                        'comments'
                    ]
                ]
            ]]);
    }

    public function test_paginated_article_index_without_comments(): void
    {
        $page = 1;
        $number = 4;
        Article::factory($number)->create();
        $withComments = 0;

        $url = "/api/articles?page=$page&number=$number&with_comments=$withComments";
        $response = $this->getJson($url);
        $response->assertJson(function (AssertableJson $json) use ($number) {
            $json->hasAll(['data', 'message', 'status', 'code']);
        })->assertJsonCount($number, 'data.data')
            ->assertJsonPath('data.data.0.comments', function ($comment) {
                return !isset($comment);
            });
    }
}
