<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProjectUsageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-usage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'proj_usg_id') ?>

    <?= $form->field($model, 'proj_usg_usage') ?>

    <?= $form->field($model, 'proj_usg_creator') ?>

    <?= $form->field($model, 'proj_id') ?>

    <?= $form->field($model, 'alternate') ?>

    <?php // echo $form->field($model, 'sts_proj_usg_id') ?>

    <?php // echo $form->field($model, 'cat_usg_id') ?>

    <?php // echo $form->field($model, 'user_email') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
