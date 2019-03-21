<?php
namespace frontend\controllers;

use common\models\SippmAssignment;

class SippmAssignmentController extends \yii\web\Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateAssignment()
    {
        $model = new SippmAssignment();

        return $this->render('_form', [
            'model' => $model
        ]);
    }

}
