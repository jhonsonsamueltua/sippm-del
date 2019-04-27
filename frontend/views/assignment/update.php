<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Update Assignment: ' . $modelAsg->asg_id;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelAsg->asg_id, 'url' => ['view', 'id' => $modelAsg->asg_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-experiment', [
        'modelAsg' => $modelAsg,
        'modelClass' => $modelClass,
    ]) ?>
    
</div>
