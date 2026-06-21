<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $categories = Category::where('user_id', $request->user()->id)
            ->withCount('produks')
            ->latest()
            ->get();

        return $this->success($categories, 'Data category');
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

        return $this->created($category, 'Category berhasil dibuat');
    }

    public function show(Request $request, string $id)
    {
        $category = Category::withCount('produks')
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (!$category) {
            return $this->notFound('Category tidak ditemukan');
        }

        return $this->success($category, 'Detail category');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
        ]);

        $category = Category::where('user_id', $request->user()->id)->find($id);

        if (!$category) {
            return $this->notFound('Category tidak ditemukan');
        }

        $category->update(['nama_category' => $request->nama_category]);

        return $this->success($category, 'Category berhasil diupdate');
    }

    public function destroy(Request $request, string $id)
    {
        $category = Category::where('user_id', $request->user()->id)->find($id);

        if (!$category) {
            return $this->notFound('Category tidak ditemukan');
        }

        if ($category->produks()->count() > 0) {
            return $this->error('Category tidak bisa dihapus karena masih memiliki produk.', 422);
        }

        $category->delete();

        return $this->success(null, 'Category berhasil dihapus');
    }
}
