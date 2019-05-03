<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $model->proj->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proj_usg_id, 'url' => ['view', 'id' => $model->proj_usg_id]];
$this->params['breadcrumbs'][] = 'Update';
$css = ['css/site.css'];
?>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">
        <h3><b> Edit Request Penggunaan</b> </h3>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'project' => $project,
        ]) ?>
    </div>
</div>
