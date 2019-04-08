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
$css = ['css/site.css'
                ];

?>
<div id="reqsub" class="section">
<div class="sippm-project-form">
<div class="container">
	<div class="row">
		<div class="reqsub-form">
        <div class="reqsub-bg">
        <div class="form-header">
        <h2>Submit Proyek</h2>
            <p>Silahkan melakukan <b>Unggah proyek</b> pada form Submit proyek ini.</p>
            <br>
            <br>
            <!-- <h4>Hal yang wajib diketahui : </h4>
            <p><b>*</b>Proyek yang direquest untuk diunduh akan di teruskan kepada koordinator proyek</p>
            <p><b>*</b>Ketika request dikirim, notifikasi akan masuk kepada koordinator</p>
            <p><b>*</b>Kordinator dapat menolak dan menerima request penggunaan</p>
            <p><b>*</b>Apabila request diterima atau ditolak, notifikasi akan masuk kepada perequest</p>
            <p><b>*</b>Ketika request diterima proyek baru dapat diunduh</p> -->

        </div>
    </div>

<form>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'proj_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
        'options' => [
            'minHeight' => 500,
        ],
    ]) ?>

    <?= $form->field($model, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'), [
        "id" => "cat_proj",
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
                    <div class='row'>
                ");
                foreach($files as $file){
                    echo "<p class='col-sm-3'>" . $file->file_name . "</p>" . "<p class='col-sm-9'>" . Html::a('-', ['#'], ['class' => 'btn btn-danger']) . "</p>";
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
            <div id="file_field" class="col-md-6">
                <input type="file" class="form-control" name="files[]">
            </div>
            <a href="#" onclick="addMoreFile()">Add More File</a>
        </div>
    </div>

    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-submit' : 'btn btn-primary']) ?>
    </div>
    </div>
</form>
</div>
</div>
</div>
</div>
</div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>

    <?php
        $this->registerJs("

            $(document).ready(function(){
                var category = $('#cat_proj').val();

                if(category == 1) $('#sts_win').hide();
            });
            
            $(document.body).on('change', '#cat_proj', function(){
                var value = $('#cat_proj').val();

                if(value != 1){
                    $('#sts_win').show();
                }else{
                    $('#sts_win').hide();
                }
            });

            function addMoreFile(){
                $('#file_field').append('<input type=file class=form-control name=files[]>');
            }
        
        ", $this::POS_END);
    ?>

</div>
