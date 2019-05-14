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
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
?>


<div class="body-content">
    <div class=" container box-content">
        
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-dosen'],
                        ],
                        'Tambah Penugasan',
                    ],
                ]);
            ?>
        
        <h3 class=""> <b> Ubah Penugasan </b></h3>
        <hr class="hr-custom">

        <?= $this->render('_form-experiment', [
            'modelAsg' => $modelAsg,
            'modelClass' => $modelClass,
        ]) ?>
    </div>
</div>
