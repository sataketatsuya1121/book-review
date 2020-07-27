<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Services\BookReviewApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookReviewController extends Controller
{
    private $review;
    private $bookServiceApi;

    public function __construct(Review $review, BookReviewApiService $bookServiceApi)
    {
        $this->review = $review;
        $this->bookServiceApi = $bookServiceApi;
    }

    /**
     * 楽天APIを叩いて取得した配列結果からレビュー件数をまとめて返す
     *
     * @param Request $request
     * @return array
     */
    public function createReviewCountApi(Request $request): array
    {
        $isbnArray = $this->bookServiceApi->revertIsbnToArray($request);
        $reviewsGroupedByIsbn = $this->review->getIsbnByReviewd($isbnArray);
        return $this->bookServiceApi->setReviewCount($reviewsGroupedByIsbn, $isbnArray);
    }

    /**
     * 楽天APIを叩いて取得した配列結果からレビュー平均評価をまとめて返す
     *
     * @param Request $request
     * @return array
     */
    public function createStarCountApi(Request $request): array
    {
        $isbnArray = $this->bookServiceApi->revertIsbnToArray($request);
        $evlGroupedByIsbn = $this->review->getIsbnByEvl($isbnArray);
        return $this->bookServiceApi->setReviewEvaluation($evlGroupedByIsbn, $isbnArray);
    }

    /**
     * 未読通知Apiを作成してフロントに返す
     *
     * @return array
     */
    public function createNotificationApi(Notification $notification): Collection
    {
        return $notification->getUnreadNotifications();
    }
}
