<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
use yii\widgets\Breadcrumbs;
$this->title = 'Tambah Penugasan';
?>
<div class="body-content">
    <div class=" container box-content">
    <h3 class=""> <b> Tambah Penugasan </b></h3>
    <hr class="hr-custom">
        <!-- <div style="float:right; margin-top: 10px;">
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
        </div> -->

        <!-- <div class="assignment-create"> -->

            <?= $this->render('_form-experiment', [
                'modelAsg' => $modelAsg,
            ]) ?>

        <!-- </div> -->

    </div>
</div>
