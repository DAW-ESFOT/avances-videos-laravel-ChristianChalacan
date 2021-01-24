<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::paginate(10)) ;
    }

    public function show(Article $article)
    {
        return response()->json(new ArticleResource($article),200) ;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
            ]);
        $article =  Article::create($validatedData);
        return response()->json(new ArticleResource($article),201);
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
