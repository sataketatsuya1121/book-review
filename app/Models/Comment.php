<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
        'content',
        'created_at',
        'ISBN',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isMyComment(int $commentId): bool
    {
        return $this->where('user_id', Auth::id())
                    ->where('id', $commentId)
                    ->exists();
    }
}
