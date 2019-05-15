<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

// $this->title = 'Submit Proyek';
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
use yii\widgets\Breadcrumbs;
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>


<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content "> 

        <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-student'],
                        ],
                        'Unggah Proyek',
                    ],
                ]);
            ?>
        <br>
        <h4> <b>Unggah Proyek</b> </h4>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'assignment' => $assignment,
            'late' => $late,
        ]) ?>
    
    </div> 
</div>
