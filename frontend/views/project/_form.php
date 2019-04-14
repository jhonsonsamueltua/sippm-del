<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\StatusWin;
use common\models\CategoryProject;
use frontend\controllers\AssignmentController;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */
/* @var $form yii\widgets\ActiveForm */
$css = ['css/site.css'];
?>

<div id="reqsub">
    <!-- <div class="sippm-project-form"> -->
        <div class="container">
	        <div class="row">
		        <div class="reqsub-form">
                    <div class="reqsub-bg">
                        <div class="form-header" style="color:white;">
                            <h3><b style="font-size: 18px"><?= $assignment->asg_title ?></b></h3>
                            <hr>

                            <b style="font-size: 16px">Deskripsi</b>
                            <?= $assignment->asg_description ?>
                            
                            <b style="font-size: 16px">Status penugasan</b>
                            
                            <p><?php
                                $status = AssignmentController::getProject($assignment["asg_id"]);
                                if($model->isNewRecord){
                                    echo "Sudah submit";
                                }else{
                                    echo "Belum submit";
                                }
                            ?></p>

                            <b style="font-size: 16px">Batas Waktu</b>
                            <?php
                                $old_date = $assignment->asg_end_time;
                                $old_date_timestamp = strtotime($old_date);
                                $new_date = date('l, d M Y, H:i', $old_date_timestamp);
                            ?>
                            <p><?= $new_date ?></p>

                            <b style="font-size: 16px">Waktu yang Tersisa</b>
                            <p>
                            <?php 
                                date_default_timezone_set("Asia/Bangkok");
                                $asg_end_time = new DateTime($assignment->asg_end_time);
                                if($model->isNewRecord && isset($model->updated_at)){
                                    $updated_at = new DateTime($assignment->asg_end_time);
                                    $interval = $updated_at->diff($asg_end_time);
                                    echo $interval->format("Di kirim %a hari, %h jam, %i menit lebih awal");
                                }elseif($model->isNewRecord && isset($model->created_at)){
                                    $created_at = new DateTime($assignment->asg_end_time);
                                    $interval = $created_at->diff($asg_end_time);
                                    echo $interval->format("Di kirim %a hari, %h jam, %i menit lebih awal");
                                }else{
                                    $now = new DateTime();
                                    $interval = $asg_end_time->diff($now);
                                    echo $interval->format("%a hari, %h jam, %i menit");
                                }
                            ?>
                            </p>

                            <b style="font-size: 16px">Terakhir Modifikasi</b>
                            <p><?= isset($assignment->updated_at) ? $assignment->updated_at : ' &nbsp;- - -' ?></p> 
                        </div>
                    </div>
                        <?php $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data']
                        ]); ?>

                        <!-- <?= $form->field($model, 'proj_title')->textInput(['readOnly' => !$model->isNewRecord,'maxlength' => true]) ?> -->
                        
                        <?= $form->field($model, 'proj_title')->textInput(['readOnly' => false, 'maxlength' => true, 'style' => 'font-weight: 700']) ?>
                        
                        <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
                            'options' => [
                                'minHeight' => 500,
                            ],
                        ]) ?>
                        
                        <?= $form->field($model, 'proj_author')->textArea(['rows' => '3'])->label("Penulis (Pisahkan Penulis dengan tanda titik koma [ ; ] )") ?>

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
                            <div id="file_field" class="col-md-6">
                                <input type="file" class="form-control" name="files[]">
                            </div>
                            <a href="#" onclick="addMoreFile()">Add More File</a>
                        </div>
                    </div>

                        <div class="form-group" align="center">
                            <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-submit' : 'btn btn-primary']) ?>
                                <?php
                                if(!$model->isNewRecord){
                                    echo Html::a("Kembali", ['assignment/assignment-student'], ['class' => 'btn btn-primary']);
                                }
                            ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>
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
