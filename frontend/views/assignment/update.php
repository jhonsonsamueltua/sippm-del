<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Update Assignment: ' . $modelAsg->asg_title;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelAsg->asg_id, 'url' => ['view', 'id' => $modelAsg->asg_id]];
$this->params['breadcrumbs'][] = 'Update';
$css = ['css/site.css'];
?>

<?php
    $listKelas = array();
    $listKelas = $this->context->getAllClass();
?>
<br>
<div class="assignment-update">

    <h2 class="text-h2">Update Penugasan <b> <?= Html::encode($this->title) ?> </b> </h2>
    <hr class="hr-custom">

    <?= $this->render('_form', [
        'modelAsg' => $modelAsg,

        'modelsClsAsg' => (empty($modelsClsAsg)) ? [new ClassAssignment] : $modelsClsAsg,

        'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new StudentAssignment]] : $modelsStuAsg,

        'listKelas' => $listKelas,
    ]) ?>
    
</div>
