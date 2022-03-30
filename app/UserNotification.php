<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'is_read', 'user_id', 'client_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getSummary($user_id)
    {
        $notifications = self::where('user_id', $user_id)
            ->where('is_read', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $count = count($notifications);

        $lastNotifications = $notifications->take(3);

        return [
            'count' => $count,
            'notifications' => $lastNotifications,
        ];
    }
}
