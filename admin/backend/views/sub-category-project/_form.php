<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategoryProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-category-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sub_cat_proj_id')->textInput() ?>

    <?= $form->field($model, 'sub_cat_proj_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat_proj_id')->textInput() ?>

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
