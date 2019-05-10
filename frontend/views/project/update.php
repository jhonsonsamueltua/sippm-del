<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = ' Proyek: ' . $model->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proj_id, 'url' => ['view', 'id' => $model->proj_id]];
$this->params['breadcrumbs'][] = 'Update'; 
use yii\widgets\Breadcrumbs;
?>
<div class="body-content">
    <div class=" container box-content">

        <div class="row" style="float:right;">
        <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-student'],
                        ],
                        'Edit Penugasan',
                    ],
                ]);
            ?>
        </div>

        <h3 class=""> <b> Edit Proyek  </b></h3>
        <hr class="hr-custom">
        <?= $this->render('_form', [
            'model' => $model,
            'files' => $fileModel,
            'assignment' => $assignment,
            'late' => $late,
        ]) ?>
    </div>
</div>
