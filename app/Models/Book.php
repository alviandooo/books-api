<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'code',
        'title',
        'author',
        'stock',
        'category_id',
        'created_by',
    ];
}
