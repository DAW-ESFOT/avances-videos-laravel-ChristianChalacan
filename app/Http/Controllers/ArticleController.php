<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    private static $rules = [
        'title' => 'required|string|unique:articles|max:255',
        'body' => 'required',
        'category_id' => 'required|exists:categories,id'
    ];
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
        $request->validate([
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|dimensions:min_width=200,min_height=200',
        ]);
        $article = new Article($request->all());
        $path = $request->image->store('public/articles');
        $article->image = $path;
        $article->save();
        return response()->json(new ArticleResource($article),201);
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|unique:articles,title,'.$article->id.'|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
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
