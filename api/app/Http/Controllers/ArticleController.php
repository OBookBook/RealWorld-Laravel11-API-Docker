<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'body' => 'required|string'
        ]);

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->description = $validatedData['description'];
        $article->body = $validatedData['body'];
        $article->save();

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
    public function update(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'body' => 'sometimes|required|string'
        ]);
    
        $article->update($validatedData);
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
