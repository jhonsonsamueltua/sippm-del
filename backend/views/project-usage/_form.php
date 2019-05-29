<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-usage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proj_usg_usage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proj_usg_creator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proj_id')->textInput() ?>

    <?= $form->field($model, 'sts_proj_usg_id')->textInput() ?>

    <?= $form->field($model, 'cat_usg_id')->textInput() ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <?= $form->field($model, 'deleted_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
