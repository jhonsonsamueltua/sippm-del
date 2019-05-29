<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = 'Update Project Usage: ' . $model->proj_usg_id;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proj_usg_id, 'url' => ['view', 'id' => $model->proj_usg_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-usage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
