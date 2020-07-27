<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    public $table = 'notifications';

    /**
     * IDから通知を既読マークをつける
     * notificationsテーブルのread_atカラム更新
     *
     * @param string $notificationId
     * @return void
     */
    public function markNotificationAsRead(string $notificationId): void
    {
        Auth::user()->unreadNotifications
                    ->where('id', $notificationId)
                    ->first()
                    ->markAsRead();
    }

    /**
     * IDから通知を既読マークをつける
     * notificationsテーブルのread_atカラム更新
     *
     * @param string $notificationId
     * @return void
     */
    public function markAllNotificationsAsRead(): void
    {
        Auth::user()->unreadNotifications
                    ->markAsRead();
    }

    /**
     * 未読通知をデータベースから取得
     *
     * @return Collection|null
     */
    public function getUnreadNotifications():? Collection
    {
        return Auth::user()->unreadNotifications->pluck('data', 'id');
    }
}
