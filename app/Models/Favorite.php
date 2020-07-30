<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'fav_user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fav_user_id');
    }

    public function favoritedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * お気に入り履歴を確認
     *
     * @param integer $favoriteId
     * @return boolean
     */
    public function checkFavoriteDone(int $favoriteId): bool
    {
        return $this->where('user_id', Auth::id())
                    ->where('fav_user_id', $favoriteId)
                    ->exists();
    }

    /**
     * お気に入りに登録
     *
     * @param integer $favoriteId
     * @return void
     */
    public function storeFavorite(int $favoriteId)
    {
        $this->create(['user_id' => Auth::id(), 'fav_user_id' => $favoriteId]);
    }

    /**
     * IDで過去のお気に入りを削除
     *
     * @param integer $favoriteId
     * @return void
     */
    public function destroyFavoriteById(int $favoriteId)
    {
        $this->where('user_id', Auth::id())
            ->where('fav_user_id', $favoriteId)
            ->first()
            ->delete();
    }

    /**
     * ログインして入るユーザーをお気に入り登録しているユーザーを取得
     *
     * @return Collection
     */
    public function getUsersFavoriteAuthUser(): Collection
    {
        return $this->select(['user_id', 'fav_user_id'])
                    ->where('fav_user_id', Auth::id())
                    ->get();
    }
}
