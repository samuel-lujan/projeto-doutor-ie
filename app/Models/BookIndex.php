<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(Book::class, 'book_id', 'id');
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

    /**
     * Get all of the subindexes for the BookIndex
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subindexes(): HasMany
    {
        return $this->hasMany(BookIndex::class, 'index_id', 'id');
    }

}
