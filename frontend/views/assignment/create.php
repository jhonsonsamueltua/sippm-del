<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = 'Tambah Penugasan';
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="assignment-create">
    <br><br>

    <?= $this->render('_form-experiment', [
        'modelAsg' => $modelAsg,
    ]) ?>

</div>
