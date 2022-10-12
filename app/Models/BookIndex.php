<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookIndex extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'index_id',
        'title',
        'page',
    ];

    /**
     * Get the book that owns the BookIndex
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(book::class, 'book_id', 'id');
    }

    /**
     * Get the index that owns the BookIndex
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function index(): BelongsTo
    {
        return $this->belongsTo(BookIndex::class, 'index_id', 'id');
    }

}
