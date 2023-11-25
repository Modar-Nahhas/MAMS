<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CommentRequest $request, $articleId)
    {
        /** @var Article $article */
        $article = Article::query()->findOrFail($articleId);
        $data = $request->validated();
        $comments = $article->comments()->applyAllFilters($data);
        return self::getJsonResponse('Success', $comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, $articleId)
    {
        $this->authorize('create');
        /** @var Article $article */
        $article = Article::query()->findOrFail($articleId);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $comment = $article->comments()->create($data);
        return self::getJsonResponse('Success',$comment);

    }
}
