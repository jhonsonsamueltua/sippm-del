<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\redactor\widgets\Redactor;
use dosamigos\datetimepicker\DateTimePicker;

$this->title = "Create new assignment";
?>
<div class="create-assignment">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'asg_title')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'asg_description')->widget(Redactor::className()) ?>

            <?= $form->field($model, 'asg_start_time')->widget(DateTimePicker::className(), [
                'size' => 'ms',
                'template' => '{input}',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'todayBtn' => true,
                    'keyboardNavigation' => true,
                ]
            ]); ?>

            <?= $form->field($model, 'asg_end_time')->widget(DateTimePicker::className(), [
                'size' => 'ms',
                'template' => '{input}',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'todayBtn' => true,
                    'keyboardNavigation' => true,
                ]
            ]); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>