<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = ' Proyek: ' . $model->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proj_id, 'url' => ['view', 'id' => $model->proj_id]];
$this->params['breadcrumbs'][] = 'Update';  
?>
<div class="body-content">
    <div class=" container box-content">
        <h3 class=""> <b> Edit Proyek  </b></h3>
        <hr class="hr-custom">
        <?= $this->render('_form', [
            'model' => $model,
            'files' => $fileModel,
            'assignment' => $assignment,
        ]) ?>
    </div>
</div>
