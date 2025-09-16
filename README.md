# Laravel Catalog API

A simple **Laravel 12 REST API** for managing a catalog with **categories** and **items**, using **Sanctum API token authentication**.

---

## 1. Clone Repository & Install Dependencies


git clone https://github.com/sha855/item-category.git


composer install

## 2. Environment Configuration

## Copy the example environment file:

cp .env.example .env


## 3. Install & Setup Laravel Sanctum


## Run all migrations (this will create users, categories, items, and personal_access_tokens tables):

php artisan migrate


## 4. Seed Database

Seed the database with test data:

php artisan db:seed  OR php artisan migrate:fresh --seed


## 5. Start Development Server
php artisan serve


API base URL: http://127.0.0.1:8000/api


## 6. Authentication (API Tokens)

## Register User

POST /api/auth/register

{
  "name": "Mohd",
  "email": "mohd@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}


Response:

{
  "user": { "id": 1, "name": "Mohd", "email": "mohd@example.com" },
  "token": "1|abcdefg123456..."
}

## Login

POST /api/auth/login

{
  "email": "mohd@example.com",
  "password": "secret123"
}


Response:

{
  "user": { "id": 1, "name": "Mohd", "email": "mohd@example.com" },
  "token": "1|abcdefg123456..."
}


## Logout

POST /api/auth/logout

Headers:

Authorization: Bearer <token>
Accept: application/json


Response:

{
  "message": "Logged out successfully"
}


Token is revoked; using it again returns 401 Unauthenticated.

## 7. Categories & Items API

All endpoints require Bearer token authentication.

## Get Categories

GET /api/categories

Headers:

Authorization: Bearer <token>
Accept: application/json


Response:

[
  { "id": 1, "name": "Electronics", "slug": "electronics" },
  { "id": 2, "name": "Furniture", "slug": "furniture" }
]

## Get Items in Category

GET /api/categories/{category:slug}/items


## :: Example (http://127.0.0.1:8000/api/categories/electronics/items?page=1&per_page=10&q=Item&min_price=10&max_price=50&sort=price_asc)

Query Parameters:

Param	Type	Description
page	int	Page number (default 1)
per_page	int	Items per page (default 10, max 50)
q	string	Search in item name
min_price	float	Minimum price filter
max_price	float	Maximum price filter
sort	string	price_asc, price_desc, name_asc, name_desc

Response (Paginated):

{
  "current_page": 1,
  "data": [
    {
      "id": 3,
      "name": "iPhone 14",
      "description": "Latest Apple phone",
      "price": "999.99",
      "category_id": 1,
      "created_at": "2025-09-16T12:00:00.000000Z",
      "updated_at": "2025-09-16T12:00:00.000000Z"
    }
  ],
  "per_page": 10,
  "total": 50
}

