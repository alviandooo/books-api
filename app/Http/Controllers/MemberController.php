<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $members = Member::with(['user:id,name'])->get();
            return new MemberResource(200, 'berhasil mendapatkan data member', $members);
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
                'name' => 'required|string|max:255',
                'created_by' => 'integer',
            ]);

            $member = Member::create([
                'name' => $request->name,
                'created_by' => $request->created_by,
                'isActive' => true,
            ]);

            return new MemberResource(201, 'Member berhasil dibuat!', $member);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Gagal menambahkan member baru!'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $member = Member::with(['user:id,name'])->findOrFail($id);
            return new MemberResource(200, 'berhasil mendapatkan data member', $member);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Member not found!'], 404);
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
                'name' => 'sometimes|required|string|max:255',
                'created_by' => 'sometimes|integer',
                'isActive' => 'sometimes|boolean',
            ]);

            $member = Member::findOrFail($id);
            $member->update(array_filter($request->only(['name', 'created_by', 'isActive'])));

            return new MemberResource(200, 'Member berhasil diperbarui!', $member);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Member not found!'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui member!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();

            return response()->json(['message' => 'Member berhasil dihapus!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Member not found!'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus member!'], 500);
        }
    }
}
