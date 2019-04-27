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
<br>
<div class="project-usage-update">

    <h2 class="text-h2">Update Penggunaan Proyek <b> <?= Html::encode($this->title) ?> </b> </h2>
    <hr class="hr-custom">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<br>
</div>
