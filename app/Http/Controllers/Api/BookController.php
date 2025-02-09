<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::with(['user:id,name', 'category:id,name'])->get();
            return new BookResource(200, 'berhasil mendapatkan data book', $books);
        } catch (\Exception $e) {
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
                'code' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
            ]);

            $bookData = $request->only(['code', 'title', 'author', 'stock', 'category_id']);
            // $bookData['created_by'] = auth()->id(); // jika user yang login
            $bookData['created_by'] = User::where('role', 'admin')->pluck('id')->first();

            $book = Book::where('code', $bookData['code'])->first();

            if ($book) {
                $book->stock += $bookData['stock'];
                $book->save();
            } else {
                $bookData['stock'] = $request->stock;
                $book = Book::create($bookData);
            }

            return new BookResource(201, 'Buku berhasil ditambahkan!', $book);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Gagal menambahkan buku!'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = Book::with(['user:id,name', 'category:id,name'])->findOrFail($id);
            return new BookResource(200, 'berhasil mendapatkan data book', $book);
        } catch (\Exception $e) {
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
                'code' => 'sometimes|required|string|max:255',
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string|max:255',
                'stock' => 'sometimes|required|integer',
                'category_id' => 'sometimes|required|exists:categories,id',
            ]);

            $book = Book::findOrFail($id);
            $bookData = $request->only(['code', 'title', 'author', 'stock', 'category_id']);

            $book->update(array_filter($bookData));

            return new BookResource(200, 'Buku berhasil diperbarui!', $book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui buku!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return new BookResource(200, 'Buku berhasil dihapus!', $book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus buku!'], 500);
        }
    }
}
