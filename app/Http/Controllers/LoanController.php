<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'member_id' => 'required|exists:members,id',
                'loan_date' => 'required|date',
                'return_date' => 'nullable|date|after_or_equal:loan_date',
                'created_by' => 'required|exists:users,id',
                'updated_by' => 'required|exists:users,id',
            ]);

            $request->merge(['no_transaction' => strtoupper(uniqid('TXN_')) . '-' . rand(1000, 9999)]);
            $loan = Loan::create($request->only(['no_transaction', 'book_id', 'member_id', 'loan_date', 'return_date', 'created_by', 'updated_by']));

            $book = Book::findOrFail($request->book_id);
            $book->decrement('stock'); // Asumsikan ada kolom 'stock' di tabel 'books'

            return new LoanResource(201, 'Data Peminjaman Buku berhasil disimpan!', $loan);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Gagal menyimpan data! ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function loan(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'member_id' => 'required|exists:members,id',
                'loan_date' => 'required|date',
                'return_date' => 'nullable|date|after_or_equal:loan_date',
                'created_by' => 'required|exists:users,id',
                'updated_by' => 'required|exists:users,id',
            ]);

            $book = Book::findOrFail($request->book_id);
            if ($book->stock <= 0) {
                return response()->json(['error' => 'Stock buku sudah habis!'], 400);
            }

            $request->merge(['no_transaction' => strtoupper(uniqid('TXN_')) . '-' . rand(1000, 9999)]);
            // simpan data peminjaman
            $loan = Loan::create($request->only(['no_transaction', 'book_id', 'member_id', 'loan_date', 'return_date', 'created_by', 'updated_by']));

            $book->decrement('stock'); // kurangi stok buku

            return new LoanResource(201, 'Data Peminjaman Buku berhasil disimpan!', $loan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data! ' . $e->getMessage()], 500);
        }
    }

    public function restore(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'member_id' => 'required|exists:members,id',
                'return_date' => 'required|date|after_or_equal:loan_date',
                'updated_by' => 'required|exists:users,id',
            ]);

            // check data loan jika ada
            $loan = Loan::where('book_id', $request->book_id)
                        ->where('member_id', $request->member_id)
                        ->whereNull('return_date')
                        ->firstOrFail();

            $loan->return_date = $request->return_date;
            $loan->updated_by = $request->updated_by;
            $loan->save();

            // kembalikan stok buku
            $book = Book::findOrFail($request->book_id);
            $book->increment('stock');

            return new LoanResource(200, 'Data Pengembalian Buku berhasil disimpan!', $loan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data! ' . $e->getMessage()], 500);
        }
    }

    public function listLoan()
    {
        try {
            $loans = Loan::with(['book:id,title', 'member:id,name'])
                ->whereNull('return_date')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mendapatkan daftar buku yang dipinjam',
                'data' => $loans
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mendapatkan data! ' . $e->getMessage()], 500);
        }
    }

}
