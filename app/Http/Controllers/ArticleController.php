<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:' . \App\Enums\PermissionsEnum::ReviewArticle->value)->only([
            'reviewArticle'
        ]);
        $this->middleware('permission:' . \App\Enums\PermissionsEnum::ApproveArticle->value)->only([
            'approveArticle'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $articles = Article::query()->applyAllFilters($data);
        return self::getJsonResponse('Success', $articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request): JsonResponse
    {
        $this->authorize('create', Article::class);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        /** @var Article $newArticle */
        $newArticle = Article::query()->create($data);
        return self::getJsonResponse('Success', $newArticle);
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $data['where_id'] = $id;
        /** @var Article $article */
        $article = Article::query()->loadRelations($data)->filter($data)->firstOrFail();
        $this->authorize('view', $article);
        return self::getJsonResponse('Success', $article);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        /** @var Article $article */
        $article = Article::query()->findOrFail($id);
        $this->authorize('update', $article);
        $article->update($data);
        return self::getJsonResponse('Success', $article);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        /** @var Article $article */
        $article = Article::query()->findOrFail($id);
        $this->authorize('delete', $article);
        $res = Article::deleteArticle($article);
        $message = 'Success';
        if (!$res) {
            $message = 'Failed';
        }
        return self::getJsonResponse($message, null, $res);
    }

    public function reviewArticle($id): JsonResponse
    {
        $this->authorize('review');
        /** @var Article $article */
        $article = Article::query()->findOrFail($id);
        $article->review();
        return self::getJsonResponse('Article has been reviewed', $article);
    }

    public function approveArticle($id): JsonResponse
    {
        $this->authorize('approve');
        /** @var Article $article */
        $article = Article::query()->findOrFail($id);
        $article->approve();
        return self::getJsonResponse('Article has been approved', $article);
    }
}
