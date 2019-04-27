<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
use yii\widgets\Breadcrumbs;
$this->title = 'Tambah Penugasan';
?>

<div style="float:right; margin-top: 10px;">
    <?php
        echo Breadcrumbs::widget([
            'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
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

<?php
    $listKelas = array();
    $listKelas = $this->context->getAllClass();
?>

<div class="assignment-create">
    <br><br>

    <?= $this->render('_form', [
        'modelAsg' => $modelAsg,

        'modelsClsAsg' => (empty($modelsClsAsg)) ? [new ClassAssignment] : $modelsClsAsg,

        'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new StudentAssignment]] : $modelsStuAsg,

        'listKelas' => $listKelas,
    ]) ?>

</div>
