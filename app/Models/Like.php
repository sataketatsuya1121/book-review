<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use kanazaca\CounterCache\CounterCache;

class Like extends Model
{
    use CounterCache;

    public $counterCacheOptions = [
        'Review' => [
            'field' => 'likes_count',
            'foreignKey' => 'review_id'
        ]
    ];

    protected $fillable = [
        'user_id',
        'review_id',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * いいね履歴を確認
     *
     * @param integer $reviewId
     * @return boolean
     */
    public function checkLikeDone(int $reviewId): bool
    {
        return $this->where('user_id', Auth::id())
                    ->where('review_id', $reviewId)
                    ->exists();
    }

    /**
     * いいねを登録
     *
     * @param integer $reviewId
     * @return void
     */
    public function storeLike(int $reviewId)
    {
        $this->create(['user_id' => Auth::id(), 'review_id' => $reviewId]);
    }

    /**
     * IDで過去のいいねを削除
     *
     * @param integer $reviewId
     * @return void
     */
    public function destroyLikeById(int $reviewId)
    {
        $this->where('user_id', Auth::id())
            ->where('review_id', $reviewId)
            ->first()
            ->delete();
    }
}
