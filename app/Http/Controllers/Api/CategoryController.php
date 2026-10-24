<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori foto.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'data'   => CategoryResource::collection($categories),
            // Format array string sederhana agar kompatibel langsung dengan dropdown React (categories.map(c => ...))
            'names'  => $categories->pluck('category'),
        ]);
    }

    /**
     * Tambah kategori baru (jika diperlukan oleh admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100|unique:categories,category',
        ]);

        $category = Category::create($validated);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }
}
