<?php

namespace App\Services;

use App\Services\NotificationService;

class AchievementService
{
    /**
     * レビュー回数に応じて数値を返す
     *
     * @param integer $reviewCount
     * @return integer
     */
    public function getAchievement(int $reviewCount): int
    {
        if ($reviewCount >= config('const.book_review.RANK_GOLD')) {
            return 1;
        } elseif ($reviewCount >= config('const.book_review.RANK_SILVER')) {
            return 2;
        } elseif ($reviewCount >= config('const.book_review.RANK_BRONZE')) {
            return 3;
        } else {
            return 4;
        }
    }

    /**
     * レビュー回数がランク到達点に達したかどうか確認
     * 達していたらメール送信
     *
     * @param int $reviewCount
     */
    public function checkAchievement(int $reviewCount)
    {
        $notificationService = new NotificationService();
        switch ($reviewCount) {
            case config('const.book_review.RANK_GOLD'):
                $notificationService->mailRankUpUsers('ゴールド');
                break;
            case config('const.book_review.RANK_SILVER'):
                $notificationService->mailRankUpUsers('シルバー');
                break;
            case config('const.book_review.RANK_BRONZE'):
                $notificationService->mailRankUpUsers('ブロンズ');
                break;
            default:
                break;
        }
    }
}
