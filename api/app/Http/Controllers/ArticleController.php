<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Get Multiple Articles
     * 
     * GET /api/articles
     * http://localhost:8080/api/articles/
     * 
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    /**
     * Get Single Article
     * 
     * GET /api/articles/:slug
     * http://localhost:8080/api/articles/1
     */
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return response()->json($article);
    }

    /**
     * Create Article
     * 
     * POST /api/articles
     * http://localhost:8080/api/articles
     * Example request body
        {
            "title": "Test Title",
            "description": "Test Description",
            "body": "Test body content"
        }
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json(['article' => $article]);
    }

        
    /**
     * Update Article
     * PUT /api/articles/:slug
     * http://localhost:8080/api/articles/1
     * Example request body
        {
            "title": "Update Title",
            "description": "Update Description",
            "body": "Update body content"
        }
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->validated());
        return response()->json(['article' => $article]);
    }

    /**
     * Delete Article
     * DELETE /api/articles/:slug
     * http://localhost:8080/api/articles/1
     */
    public function destroy(string $id)
    {
        $article = Article::where('slug', $id)->firstOrFail();
        $article->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
