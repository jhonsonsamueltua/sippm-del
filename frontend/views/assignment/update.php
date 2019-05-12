<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Update Assignment: ' . $modelAsg->asg_title;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelAsg->asg_id, 'url' => ['view', 'id' => $modelAsg->asg_id]];
$this->params['breadcrumbs'][] = 'Update';
$css = ['css/site.css'];
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content">
    <div class=" container box-content">
        
        <div class="row" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-dosen'],
                        ],
                        'Tambah Penugasan',
                    ],
                ]);
            ?>
        </div>

        <h3 class=""> <b> Edit Penugasan </b></h3>
        <hr class="hr-custom">

        <?= $this->render('_form-experiment', [
            'modelAsg' => $modelAsg,
            'modelClass' => $modelClass,
        ]) ?>
    </div>
</div>
