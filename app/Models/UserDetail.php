<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'lang',
        'dept_id',
        'birthday',
        'joined_company_date',
        'introduce',
        'ISBN',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function getByUserProfile(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->with('department')
                    ->first();
    }

    public function updateUserInfos(array $userInfos, int $userId)
    {
        $isUserId = $this->hasUserId($userId);

        if ($isUserId) {
            $this->where('user_id', $userId)->first()
                ->fill($userInfos)
                ->save();
        } else {
            $this->user_id = $userId;
            $this->fill($userInfos)
                ->save();
        }
    }

    public function hasUserId(int $userId): bool
    {
        return $this->where('user_id', $userId)
                    ->exists();
    }

    public function isRecomendBook(int $userId, string $isbn): bool
    {
        return $this->where('user_id', $userId)
                    ->where('ISBN', $isbn)
                    ->exists();
    }

    public function hasRecomendBook(int $userId): Collection
    {
        return $this->where('user_id', $userId)
                    ->pluck('ISBN');
    }

    public function destroyRecommendInfo(string $isbn)
    {
        $this->where('ISBN', $isbn)
            ->where('user_id', Auth::id())
            ->delete();
    }

    /**
     * おすすめ本履歴を確認
     *
     * @param string $isbn
     * @return boolean
     */
    public function checkRecommendDone(string $isbn): bool
    {
        return $this->where('user_id', Auth::id())
                    ->where('ISBN', $isbn)
                    ->exists();
    }
}
