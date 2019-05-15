<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
use yii\widgets\Breadcrumbs;
$this->title = 'Tambah Penugasan';
$session = Yii::$app->session;
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<div class="body-content">
    <div class=" container box-content " style="width: 65%;">

            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-dosen'],
                        ],
                        ['label' => 'Tambah Penugasan'],
                    ],
                ]);
            ?>
            <h3 class=""> <b> Tambah Penugasan </b></h3>
            <hr class="hr-custom">
        <?= $this->render('_form-experiment', [
            'modelAsg' => $modelAsg,
        ]) ?>


    </div>
</div>
