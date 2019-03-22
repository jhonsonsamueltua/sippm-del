<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sippm-project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proj_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
        'options' => [
            'minHeight' => 500,
        ],
    ])->hint("Deskripsikan proyek anda dengan singkat dan jelas") ?>

    <?= $form->field($model, 'sts_win_id')->textInput() ?>

    <?= $form->field($model, 'sts_proj_id')->textInput() ?>
    
    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

    <?php 
        echo \kato\DropZone::widget([
            'options' => [
                'maxFilesize' => '2',
            ],
            'clientEvents' => [
                'complete' => "function(file){console.log(file)}",
                'removedfile' => "function(file){alert(file.name + ' is removed')}"
            ],
        ]);
   ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
