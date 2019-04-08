<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = 'Request Pengunduhan Proyek';
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-usage-create">

    <!-- <h2><?= Html::encode($this->title) ?></h2> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
