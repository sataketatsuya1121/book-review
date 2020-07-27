<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'author',
        'img',
    ];

    protected $primaryKey = 'ISBN';

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'ISBN');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'ISBN');
    }

    public function isRequestIsbn(string $isbn): bool
    {
        return $this->where('ISBN', $isbn)
                    ->exists();
    }

    public function storeBook(array $books)
    {
        $this->img = $books['mediumImageUrl'];
        $this->fill($books)->save();
    }

    public function deleteBookByIsbn(string $isbn)
    {
        $this->where('ISBN', $isbn)
            ->first()
            ->delete();
    }

    public function isHasIsbn(string $isbn): bool
    {
        return $this->where('ISBN', $isbn)
                    ->exists();
    }
}
