<?php

namespace App\Services;

use App\Models\User;
use App\Mail\RankUpMail;
use App\Mail\ReviewMail;
use App\Mail\CommentMail;
use App\Mail\RegisterMail;
use App\Events\RankUpEvent;
use App\Events\ReviewEvent;
use App\Events\RegisterEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\RankUpCompleted;
use App\Notifications\ReviewCompleted;
use App\Notifications\CommentCompleted;
use App\Notifications\RegisterCompleted;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * リアルタイムデスクトップ通知
     * notificationsテーブルにデータを保存
     * 自分以外の全ユーザーにメール送信
     *
     * @return void
     */
    public function mailReviewUsers()
    {
        event(new ReviewEvent(Auth::user()->name . 'さんがレビューを投稿しました！'));

        Notification::send(User::all(), new ReviewCompleted());

        $user = new User();
        $emails = $user->getEmailsExceptLoginUser();
        Mail::to($emails)->send(new ReviewMail());
    }

    /**
     * リアルタイムデスクトップ通知
     * notificatoinsテーブルにデータを保存
     * 自分以外の全ユーザーにメール通知
     *
     * @param [type] $user
     * @return void
     */
    public function mailRegisteredUsers($user)
    {
        event(new RegisterEvent($user->name . 'さんがBook Reviewに参加しました！'));

        Notification::send(User::all(), new RegisterCompleted());

        $emails = $user->getEmailsExceptLoginUser();
        Mail::to($emails)->send(new RegisterMail());
    }

    /**
     * リアルタイムデスクトップ通知
     * notificationsテーブルにデータを保存
     * 全てのユーザーにメール送信
     *
     * @param string $rankMedal
     * @return void
     */
    public function mailRankUpUsers(string $rankMedal)
    {
        event(new RankUpEvent(Auth::user()->name . 'さんが' . $rankMedal . 'にランクアップしました！'));

        Notification::send(User::all(), new RankUpCompleted($rankMedal));

        $user = new User();
        $emails = $user->getAllEmails();
        Mail::to($emails)->send(new RankUpMail($rankMedal));
    }

    /**
     * notificationsテーブルにデータを保存
     * コメントしたレビュー投稿者にメール通知
     * 自分のレビューにコメント投稿した場合は通知しない
     *
     * @param integer $userId
     * @return void
     */
    public function mailCommentUser(int $userId)
    {
        if ($userId !== Auth::id()) {
            Notification::send(User::find($userId), new CommentCompleted());

            $user = new User();
            $email = $user->getEmailByUserId($userId);
            Mail::to($email)->send(new CommentMail());
        }
    }
}
