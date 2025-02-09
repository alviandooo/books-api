<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Category::with('user:id,name')->latest()->paginate(5);
            return new CategoryResource(200, 'berhasil mendapatkan data category', $data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'created_by' => 'integer',
            ]);

            $category = Category::updateOrCreate(
                ['name' => $request->name],
                ['created_by' => $request->created_by]
            );

            return new CategoryResource(201, 'berhasil membuat category baru', $category);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Gagal menambahkan category baru!'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::with('user:id,name')->findOrFail($id);
            return new CategoryResource(200, 'berhasil mendapatkan data category', $category);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found!'], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'created_by' => 'integer',
            ]);

            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'created_by' => $request->created_by,
            ]);

            return new CategoryResource(200, 'Category berhasil diubah', $category);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found!'], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Category berhasil dihapus!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found!'], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
