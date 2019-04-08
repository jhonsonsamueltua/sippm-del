<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\StatusWin;
use common\models\CategoryProject;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sippm-project-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'proj_title')->textInput(['readOnly' => !$model->isNewRecord,'maxlength' => true]) ?>

    <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
        'options' => [
            'minHeight' => 500,
        ]
    ]) ?>

    <div id="sts_win">
        <?= $form->field($model, 'sts_win_id')->dropDownList(ArrayHelper::map(StatusWin::find()->all(), 'sts_win_id', 'sts_win_name'), [
            "prompt" => "Pilih Status",
        ]) ?>
    </div>

    <?php
        if(!$model->isNewRecord){
            if(count($files) != 0){
                echo("
                    <label>File Proyek</label>
                    <div class='form-group'>
                ");
                foreach($files as $file){
                    echo "<p class='col-sm-3'>" . $file->file_name . "</p>" . "<p class='col-sm-9'>" . Html::a('-', ['remove-attachment', 'file_id' => $file->file_id], ['class' => 'btn btn-danger']) . "</p>";
                }
                echo("
                    </div>
                ");
            }
        }
    ?>

    <div class="form-group">
        <label>Upload Proyek</label>
        <div class="row">
            <div id="file_field" class="col-md-4">
                <input type="file" class="form-control" name="files[]">
            </div>
            <a href="#" onclick="addMoreFile()">Add More File</a>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <?php
            if(!$model->isNewRecord){
                echo Html::a("Kembali", ['view', 'id' => $model->proj_id], ['class' => 'btn btn-primary']);
            }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        $this->registerJs("

            $(document).ready(function(){
                if($assignment->cat_proj_id == 1) $('#sts_win').hide();
            });

            function addMoreFile(){
                $('#file_field').append('<input type=file class=form-control name=files[]>');
            }
        
        ", $this::POS_END);
    ?>

</div>
