<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publisher_user_id',
        'title',
        'raw_text',
    ];

    /**
     * Get the publisher that owns the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publisher_user_id', 'id');
    }

    /**
     * Get all of the index for the book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function index(): HasMany
    {
        return $this->hasMany(BookIndex::class, 'book_id', 'id');
    }
}
