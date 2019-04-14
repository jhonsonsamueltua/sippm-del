<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Tambah Penugasan';
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
