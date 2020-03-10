<?php

/**
 * Created by PhpStorm.
 * User=> admin
 * Date=> 2018-11-22
 * Time=> 5=>54 PM
 */
namespace HCES\Traits;

use HCES\Events\Notify;
use HCES\Notification;
use Illuminate\Support\Facades\Auth;

trait NotificationTrait
{
    public function notify($user_id, $data, $color = "info", $icon = "icon-bell")
    {
        $data['user_id'] = $user_id;
        $data['color'] = $color;
        $data['icon'] = $icon;
        $notification = new Notification($data);
        $notification->save();
        $this->broadCastNotification($notification);
    }

    public function broadCastNotification(Notification $notification)
    {
        event(new Notify($notification));
    }
}