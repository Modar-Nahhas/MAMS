<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

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
        /** @var Article $article */
        $article = Article::query()->findOrFail($articleId);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $comment = $article->comments()->create($data);
        return self::getJsonResponse('Success',$comment);

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
