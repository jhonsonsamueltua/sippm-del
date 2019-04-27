<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $project->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
?>
<div class="project-usage-create">
<br>
    <h2 class="text-h2">Request Penggunaan Proyek <b> <?= Html::encode($this->title) ?> </b> </h2>
    <hr class="hr-custom">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<br>
</div>
