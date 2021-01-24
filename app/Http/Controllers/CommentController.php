<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends Controller
{
    public function index(Article $article)
    {
        return response()-> json(CommentResource::collection($article->comments),200);
    }

    public function show(Article $article, Comment $comment)
    {
        $comment = $article->comments()->where('id',$comment->id)->firstOrFail();
        return response()->json(new CommentResource($comment),200) ;
    }

    public function store(Request $request, Article $article)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $comment = $article->comments()->save(new Comment($request->all()));
        //$article =  Article::create($validatedData);
        return response()->json(new CommentResource($comment),201);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());
        return response()->json($article,200);
    }

    public function delete(Request $request, Article $article)
    {
        try {
            $article->delete();
        } catch (\Exception $e) {
        }
        return response()->json(null,204);
    }
}
