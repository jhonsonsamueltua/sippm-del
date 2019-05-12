<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
use yii\widgets\Breadcrumbs;
$this->title = 'Tambah Penugasan';
$session = Yii::$app->session;
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
    <h3 class=""> <b> Tambah Penugasan </b></h3>
    <hr class="hr-custom">

        <?= $this->render('_form-experiment', [
            'modelAsg' => $modelAsg,
        ]) ?>


    </div>
</div>
