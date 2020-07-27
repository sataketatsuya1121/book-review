<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    private $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * IDからログインユーザーの既読情報を更新
     * 書籍詳細にリダイレクト
     *
     * @param string $notificationId
     * @param string $isbn
     * @return RedirectResponse
     */
    public function markAsReadReview(string $notificationId, string $isbn): RedirectResponse
    {
        $this->notification->markNotificationAsRead($notificationId);
        return redirect()->route('detail', $isbn);
    }

    /**
     * IDからログインユーザーの既読情報を更新
     * ユーザー詳細にリダイレクト
     *
     * @param string $notificationId
     * @param integer $userId
     * @return RedirectResponse
     */
    public function markAsReadUser(string $notificationId, int $userId): RedirectResponse
    {
        $this->notification->markNotificationAsRead($notificationId);
        return redirect()->route('user', $userId);
    }

    /**
     * 全て通知を既読
     *
     * @return void
     */
    public function markAsReadAllNotifications()
    {
        $this->notification->markAllNotificationsAsRead();
    }
}
