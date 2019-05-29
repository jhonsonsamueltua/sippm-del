<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;
use common\models\NotificationViewer;

class NotificationViewerController extends Controller{

    public static function createNotificationViewer($ntf_id, $ntf_reader){
        $reader = new NotificationViewer();

        $reader->ntf_id = $ntf_id;
        $reader->ntf_reader = (string) $ntf_reader;
        $reader->save();
    }

}

?>