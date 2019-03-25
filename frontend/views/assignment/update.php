<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Update Assignment: ' . $model->asg_id;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asg_id, 'url' => ['view', 'id' => $model->asg_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
