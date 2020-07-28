<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Support\Collection as Query;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'header',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function destroyUserInfo()
    {
        $this->where('id', Auth::id())
            ->delete();
    }

    public function getAllUsers(): Collection
    {
        return $this->with(['userDetail.department'])
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function getUserByFavorite(Collection $favorite): Collection
    {
        $favoritedUser = $this->with(['userDetail.department'])
                            ->find($favorite->pluck('fav_user_id'));
        $notFavoritedUser = $this->with(['userDetail.department'])
                                ->whereNotIn('id', $favorite->pluck('fav_user_id'))
                                ->get()
                                ->sortByDesc('created_at');
        return $favoritedUser->concat($notFavoritedUser);
    }

    public function getUserBySearch(\Illuminate\Http\Request $request): Collection
    {
        return $this->with(['userDetail.department'])
                    ->when($request->filled('keyword'), function($query) use ($request) {
                        return $query->where('name', 'like', '%' . $request->input('keyword') . '%');
                    })
                    ->when($request->filled('month'), function($query) use ($request) {
                        return $query->join('user_details', 'users.id', '=', 'user_details.user_id')
                                    ->where('joined_company_date', $request->input('month'));
                    })
                    ->when($request->filled('department'), function($query) use ($request) {
                        return $query->join('user_details', 'users.id', '=', 'user_details.user_id')
                                    ->where('dept_id', $request->input('department'));
                    })
                    ->get();
    }

    public function getUserRanking(int $deptId = null): Collection
    {
        return $this->with(['userDetail.department'])
                    ->withCount('reviews')
                    ->when(isset($deptId), function($query) use ($deptId) {
                        return $query->join('user_details', 'users.id', '=', 'user_details.user_id')
                                    ->where('dept_id', $deptId);
                    })
                    ->orderBy('reviews_count', 'DESC')
                    ->take(config('const.TOP_RANK_NUM'))
                    ->get();
    }

    public function getAuthUser(): \App\Models\User
    {
        return $this->with(['favorites'])
                    ->findOrFail(Auth::id());
    }

    /**
     * 全てのユーザーのメアドを取得
     *
     * @return Collection
     */
    public function getAllEmails(): Query
    {
        return DB::table('users')
            ->select('email')
            ->pluck('email');
    }

    /**
     * 自分以外ユーザー以外のメアドを取得
     *
     * @return Collection
     */
    public function getEmailsExceptLoginUser(): Query
    {
        return DB::table('users')
            ->select('email')
            ->where('id', '!=', Auth::id())
            ->pluck('email');
    }

    /**
     * IDからユーザーのメアドを一件取得
     *
     * @param integer $userId
     * @return string
     */
    public function getEmailByUserId(int $userId): string
    {
        return DB::table('users')
            ->select('email')
            ->where('id', $userId)
            ->value('email');
    }

    public function getFavoritedUser($userId)
    {
        return $this->with(['favorites'])
                    ->where('id', $userId)
                    ->first();
    }

    public function getUser(int $userId): \App\Models\User
    {
        return $this->with(['favorites', 'reviews.book', 'stocks.book'])
                    ->withCount('reviews')
                    ->find($userId);
    }
}
