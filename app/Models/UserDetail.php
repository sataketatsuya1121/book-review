<?php

namespace App\Models;

use App\Models\User;
use App\Models\Language;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'lang_id',
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


    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function getByUserProfile(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->with(['department', 'language'])
                    ->first();
    }

    public function updateUserInfos($userInfos, int $userId)
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
}
