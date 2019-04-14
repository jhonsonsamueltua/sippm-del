<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = ' Proyek: ' . $model->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proj_id, 'url' => ['view', 'id' => $model->proj_id]];
$this->params['breadcrumbs'][] = 'Update';  
?>
<div class="sippm-project-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <br>
    <?= $this->render('_form', [
        'model' => $model,
        'files' => $fileModel,
        'assignment' => $assignment,
    ]) ?>

</div>
