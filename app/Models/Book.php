<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = [
        'code',
        'title',
        'author',
        'stock',
        'category_id',
        'created_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
        
    }
}
