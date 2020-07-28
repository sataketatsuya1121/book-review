<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Review extends Model
{
    use Sortable;

    protected $fillable = [
        'user_id',
        'book_id',
        'evaluation',
        'likes_count',
        'content',
        'ISBN',
    ];

    public $sortable = [
        'evaluation',
        'likes_count',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'ISBN', 'ISBN');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getUserById(int $userId):? Collection
    {
        return $this->where('id', $userId)->first();
    }

    public function getReviewById(int $reviewId):? Review
    {
        return $this->findOrFail($reviewId);
    }

    public function getIsbnByReviewd(array $isbn):? Collection
    {
        return $this->whereIn('ISBN', $isbn)
                    ->get('ISBN')
                    ->groupBy('ISBN');
    }

    public function getIsbnByEvl(array $isbn):? Collection
    {
        return $this->select(['ISBN', 'evaluation'])
                    ->whereIn('ISBN', $isbn)
                    ->get()
                    ->groupBy('ISBN');
    }

    /**
     * 最新投稿順位にGroup Byでコレクションを整える
     *
     * @param integer $limit
     * @return Collection|null
     */
    public function getReviewGroupByIsbn(int $limit = null)
    {
        return $this->with(['book'])
                    ->select(DB::raw('count(*) as review_count, AVG(evaluation) as evaluation_avg, ISBN'))
                    ->take($limit)
                    ->groupBy('ISBN')
                    ->oldest()
                    ->paginate(config('const.book_review.MAX_PAGINATE_NUM'));
    }

    /**
     * ページネーション込みでレビューのある本取得
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedBooks(): LengthAwarePaginator
    {
        return $this->select('evaluation', 'ISBN')
                    ->groupBy('ISBN')
                    ->paginate(config('const.book_review.LIMIT_BOOK'));
    }

    public function sortByReviews(string $isbn):? LengthAwarePaginator
    {
        return $this->with('user', 'likes', 'comments.user')
                    ->where('ISBN', $isbn)
                    ->sortable()
                    ->latest()
                    ->paginate(config('const.book_review.MAX_PAGINATE_NUM'));
    }

    public function updateReview(int $reviewId, array $inputs)
    {
        $this->find($reviewId)
            ->fill($inputs)
            ->save();
    }

    public function countReviewByIsbn(string $isbn): int
    {
        return $this->where('ISBN', $isbn)
                    ->count();
    }

    public function getReviews(int $userId):? Collection
    {
        return $this->with('book')
                    ->where('user_id', $userId)
                    ->latest()
                    ->get();
    }
}
