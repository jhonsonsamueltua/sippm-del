<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

// $this->title = 'Submit Proyek';
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
use yii\widgets\Breadcrumbs;
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content "> 

        <div class="row" style="float:right;">
        <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-student'],
                        ],
                        'Unggah Proyek',
                    ],
                ]);
            ?>
        </div>

        <h3> <b>Unggah Proyek</b> </h3>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'assignment' => $assignment,
            'late' => $late,
        ]) ?>
    
    </div> 
</div>
