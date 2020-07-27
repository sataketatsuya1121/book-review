<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'user_id',
        'ISBN',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'ISBN', 'ISBN');
    }

    public function isStockBook(int $userId, string $isbn): bool
    {
        return $this->where('user_id', $userId)
                    ->where('ISBN', $isbn)
                    ->exists();
    }

    public function destroyStockInfo(string $isbn)
    {
        $this->where('ISBN', $isbn)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function getStockBooks(int $userId)
    {
        return $this->with('book')
                    ->where('user_id', $userId)
                    ->latest()
                    ->get();
    }

    public function countStockByIsbn(string $isbn): int
    {
        return $this->where('ISBN', $isbn)
                    ->count();
    }
}
