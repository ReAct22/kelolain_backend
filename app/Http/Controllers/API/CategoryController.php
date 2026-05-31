<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('user_id', $request->user()->id)->get();

        return response()->json([
            'message' => 'Data category',
            'data'    => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'user_id'       => $request->user()->id,
            'nama_category' => $request->nama_category,
        ]);

        return response()->json([
            'message' => 'Category berhasil dibuat',
            'data'    => $category,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $category = Category::where('user_id', $request->user()->id)->findOrFail($id);

        return response()->json([
            'message' => 'Detail category',
            'data'    => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category = Category::where('user_id', $request->user()->id)->findOrFail($id);
        $category->update(['nama_category' => $request->nama_category]);

        return response()->json([
            'message' => 'Category berhasil diupdate',
            'data'    => $category,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::where('user_id', $request->user()->id)->findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category berhasil dihapus',
        ]);
    }
}
