<?php

use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('members', MemberController::class);

Route::post('loan', [LoanController::class, 'loan']);
Route::post('return', [LoanController::class, 'restore']);
Route::get('list-loan', [LoanController::class, 'listLoan']);

