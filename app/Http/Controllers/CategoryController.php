<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Category::all(['id','name','slug'])
        ]);
    }

    public function items(Request $request, Category $category)
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
            'q' => 'string|max:255',
            'min_price' => 'numeric|min:0',
            'max_price' => 'numeric|min:0',
            'sort' => 'in:price_asc,price_desc,name_asc,name_desc',
        ]);

        if ($request->filled('min_price') && $request->filled('max_price') &&
            $request->min_price > $request->max_price) {
            return response()->json([
                'error' => 'min_price cannot be greater than max_price'
            ], 400);
        }

        $query = $category->items();

        // Filters
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc': $query->orderBy('price','asc'); break;
                case 'price_desc': $query->orderBy('price','desc'); break;
                case 'name_asc': $query->orderBy('name','asc'); break;
                case 'name_desc': $query->orderBy('name','desc'); break;
            }
        }

        $perPage = $request->get('per_page', 10);
        $items = $query->paginate($perPage)->appends($request->query());

        return response()->json($items);
    }
}

