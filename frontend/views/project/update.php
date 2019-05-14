<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = ' Proyek: ' . $model->proj_title;
use yii\widgets\Breadcrumbs;
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);

?>


<div class="body-content">
    <div class=" container box-content">

        <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-student'],
                        ],
                        'Edit Penugasan',
                    ],
                ]);
            ?>
        
        <br>
        <h4 class=""> <b> Ubah Proyek  </b></h4>
        <hr class="hr-custom">
        <?= $this->render('_form', [
            'model' => $model,
            'files' => $fileModel,
            'assignment' => $assignment,
            'late' => $late,
        ]) ?>
    </div>
</div>
