<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

// ルート定義でモデルバインディング
Route::apiResource('articles', ArticleController::class)->parameters([
    'articles' => 'article:slug'
]);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');