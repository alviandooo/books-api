<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'no_transaction',
        'book_id',
        'member_id',
        'loan_date',
        'return_date',
        'created_by',
        'updated_by',
    ];
}
