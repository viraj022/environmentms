<?php

namespace App\Repositories;

use App\UserNotification;

class UserNotificationsRepositary
{

    public function makeNotification($user_id, $message, $client_id)
    {
        $save_notification = UserNotification::create([
            "user_id" => $user_id,
            "message" => $message,
            "client_id" => $client_id,
        ]);

        if ($save_notification == true) {
            return array('status' => 1, 'message' => 'Notification sent successfully');
        } else {
            return array('status' => 0, 'message' => 'Notification sent unsuccessful');
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = UserNotification::find($notificationId);
        $notification->is_read = 1;
        $notification->save();
    }
}
