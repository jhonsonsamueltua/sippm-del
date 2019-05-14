<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use common\models\SippmNotification;

class NotificationController extends Controller{

    public static function sendAssignmentNotification($type, $asg_id, $user){
        $notification = new SippmNotification();
        $now = new \DateTime();

        $notification->ntf_type = $type;
        $notification->user_username = (string) $user;
        $notification->asg_id = $asg_id;
        $notification->created_at = $now->format('Y-m-d h:i:s');
        $notification->save();
    }

    public static function sendProjectUsageRequestNotification($type, $proj_usg_id, $user){
        $notification = new SippmNotification();
        $now = new \DateTime();

        $notification->ntf_type = $type;
        $notification->user_username = (string) $user;
        $notification->proj_usg_id = $proj_usg_id;
        $notification->created_at = $now->format('Y-m-d h:i:s');
        $notification->save();
    }

}

?>