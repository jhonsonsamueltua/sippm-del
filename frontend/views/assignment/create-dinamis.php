<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Create Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-create">

    

    <?= $this->render('_form-dinamis', [
        'modelAsg' => $modelAsg,

        'modelsClsAsg' => (empty($modelsClsAsg)) ? [new ClassAssignment] : $modelsClsAsg,

        'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new StudentAssignment]] : $modelsStuAsg,
    ]) ?>

</div>
