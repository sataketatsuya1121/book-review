<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Review;

class LikeController extends Controller
{
    private $like;
    private $review;

    public function __construct(Like $like, Review $review)
    {
        $this->like = $like;
        $this->review = $review;
    }

    /**
     * レビューIDのいいね履歴を確認してすでに履歴があったらエラーハンドル
     * 履歴がなかったらいいねを登録
     *
     * @param integer $reviewId
     * @return void
     */
    public function like(int $reviewId)
    {
        if ($this->like->checkLikeDone($reviewId)) {
            return response()->json(config('const.abort'));
        }
        $this->like->storeLike($reviewId);
        return true;
    }

    /**
     * レビューIDのいいね履歴を確認して履歴がなかったらエラーハンドル
     * 履歴があったらいいねを解除
     *
     * @param integer $reviewId
     * @return void
     */
    public function unLike(int $reviewId)
    {
        if (!$this->like->checkLikeDone($reviewId)) {
            return response()->json(config('const.abort'));
        }
        $this->like->destroyLikeById($reviewId);
        return true;
    }
}
