<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# RealWorld API Endpoints

| Method | URI                           | Action                                     | 
|--------|-------------------------------|--------------------------------------------| 
| GET   | api/articles                | articles.index › ArticleController@index   | 
| POST       | api/articles                | articles.store › ArticleController@store   | 
| GET   | api/articles/{article}      | articles.show › ArticleController@show     | 
| PUT  | api/articles/{article}      | articles.update › ArticleController@update | 
| DELETE     | api/articles/{article}      | articles.destroy › ArticleController@destroy|

## Get Multiple Articles

![image](https://github.com/OBookBook/RealWorld-Laravel11-API-Docker/assets/130152109/04e661cb-735b-4ba6-85d6-c10925389a68)

- **Request Line:** GET /api/articles
- **Request Header:** Content-Type: application/json
- **Query Parameters:** None
- **Request Body:** None
- **Request Example:** GET http://localhost:8080/api/articles
- **Response:** JSON
- **Response Example:**
```json
[
  {
    "id": 1,
    "title": "Test Title",
    "description": "Test Description",
    "body": "Test body content"
  }
]
```
- **Error Response:** Common HTTP errors  (404, 500等)
- **Error Response Example:**
```json
{
  "message": "Resource not found."
}
```

## Create Article

![image](https://github.com/OBookBook/RealWorld-Laravel11-API-Docker/assets/130152109/4685faa4-ae77-422b-9d6c-5bff68b7e680)


- **Request Line:** POST /api/articles
- **Request Header:** Content-Type: application/json
- **Query Parameters:** None
- **Request Body:**** 
```json
{
  "title": "New Title",
  "description": "New Description",
  "body": "New body content"
}
```
- **Request Example:** POST http://localhost:8080/api/articles 
- **Response:** JSON
- **Response Example:**
```json
{
  "article": {
    "id": 2,
    "title": "New Title",
    "description": "New Description",
    "body": "New body content",
    "created_at": "2024-05-03T06:52:31.000000Z",
    "updated_at": "2024-05-03T07:33:13.000000Z"
  }
}
```
- **Error Response:** Validation error (422)
- **Error Response Example:**
```json
{
  "message": "Validation error occurred.",
  "errors": {
    "title": [ "The title field is required."]
  }
}
```

## Get Single Article

![image](https://github.com/OBookBook/RealWorld-Laravel11-API-Docker/assets/130152109/1695f6d4-b3a2-474b-895f-c68df0f3f091)

- **Request Line:** GET /api/articles/{slug}
- **Request Header:** Content-Type: application/json
- **Query Parameters:** None
- **Request Body:** None
- **Request Example:** GET http://localhost:8080/api/articles/example-slug
- **Response:** JSON
- **Response Example:**
```json
{
  "id": 1,
  "title": "Test Title",
  "description": "Test Description",
  "body": "Test body content",
  "created_at": "2024-05-03T06:52:31.000000Z",
  "updated_at": "2024-05-03T07:33:13.000000Z"
}
```
- **Error Response:** Common HTTP errors (404, 500等)
- **Request Body:**
```json
{
  "message": "Resource not found."
}
```

## Update Article

![image](https://github.com/OBookBook/RealWorld-Laravel11-API-Docker/assets/130152109/9fd02eb5-f5c5-4b1c-b62f-2e1e265f302b)

- **Request Line:** PUT /api/articles/{slug}
- **Request Header:** Content-Type: application/json
- **Query Parameters:** None
- **Request Body:**** 
```json
{
  "title": "Updated Title",
  "description": "Updated Description",
  "body": "Updated body content"
}
```
- **Request Example:** PUT http://localhost:8080/api/articles/example-slug
- **Response:** JSON
- **Response Example:**
```json
{
  "article": {
    "id": 1,
    "title": "Updated Title",
    "description": "Updated Description",
    "body": "Updated body content",
    "created_at": "2024-05-03T06:52:31.000000Z",
    "updated_at": "2024-05-03T07:33:13.000000Z"
  }
}
```
- **Error Response:** Validation error (422)
- **Error Response Example:**
```json
{
  "message": "Validation error occurred.",
  "errors": {
    "title": [ "The title field is required."]
  }
}
```

## Delete Article

![image](https://github.com/OBookBook/RealWorld-Laravel11-API-Docker/assets/130152109/07d60946-e2d9-48fd-9a3f-81487f59c4ad)

- **Request Line:** DELETE /api/articles/{slug}
- **Request Header:** Content-Type: application/json
- **Query Parameters:** None
- **Request Body:** None
- **Request Example:** `DELETE http://localhost:8080/api/articles/example-slug`
- **Response:** JSON
- **Response Example:**
```json
{
  "message": "success"
}
```
- **Error Response:** Common HTTP errors  (404, 500等)
- **Error Response Example:**
```json
{
  "message": "Resource not found.",
    "exception": {
        "message": "No query results for model [App\\Models\\Article] 1",
    }
}
```

## 工夫した点

- **Requestを使用したバリデーション**: 
  - 目的: リクエストデータの整合性を保証し、不正なデータの処理を防ぐ。
  - 詳細: `api\app\Http\Requests\StoreArticleRequest.php` と `api\app\Http\Requests\UpdateArticleRequest.php` を使用して、記事の作成と更新時に必要なデータが適切に提供されているかを検証します。これにより、データベースに無効なデータが保存されるのを防ぎます。

- **リソースの自動解決**: 
  - 目的: コントローラのアクションで直接モデルを操作することで、ルーティングの複雑さを減らし、コードの可読性を向上させる。
  - 詳細: `api\routes\api.php`において、`{article}` パラメータを使用することで、Laravelのルートモデルバインディング機能が自動的に対応する `Article` モデルのインスタンスを解決し、コントローラメソッドに注入します。

- **エラーハンドリング**: 
  - 目的: アプリケーションの安定性を保ち、ユーザーに適切なフィードバックを提供する。
  - 方法: `api\bootstrap\app.php` カスタム例外ハンドラを使用して、特定のHTTPエラー（404, 405など）に対してJSON形式のエラーレスポンスを返します。これにより、クライアント側でのエラー処理が容易になります。
  
# Setup

## Environment

```shell
docker-compose up -d
```

## phpmyadmin
http://localhost:5000/

## Container Shell
```shell
docker-compose exec api bash
```

## Migrate

```shell
php artisan migrate
```