<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\StatusWin;
use common\models\CategoryProject;
use frontend\controllers\AssignmentController;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("././css/project.css");
?>

<div class="row">

    <div class="col-md-6" style="padding: 0px 25px;">

        <h3><b style="font-size: 18px">Penugasan : <?= $assignment->asg_title ?></b></h3>
        <p>
            <?= $assignment->asg_description ?>
        </p>
        <br>
        <?= DetailView::widget([
            'model' => $assignment,
            'attributes' => [

                [
                    'attribute' => '',
                    'label' => 'Tugas saya',
                    'value' => function($model){
                        $status = AssignmentController::getProject($model["asg_id"]);
                        $stat = "";
                        if($status){
                            $stat = "Sudah submit";
                        }else{
                            $stat = "Belum submit";
                        }
                        return $stat;
                    }
                ],
                [
                    'attribute' => 'stsAsg.sts_asg_name',
                    'label' => 'Status Penugasan',
                ],
                [
                    'attribute' => '',
                    'label' => 'Batas Waktu',
                    'value' => function($model){
                        $old_date = $model->asg_end_time;
                        $old_date_timestamp = strtotime($old_date);
                        $new_date = date('l, d M Y, H:i', $old_date_timestamp);
                        return $new_date;
                    }
                ],
                [
                    'attribute' => '',
                    'label' => 'Waktu tersisa',
                    'value' => function($model){
                        date_default_timezone_set("Asia/Bangkok");
                        $asg_end_time = new DateTime($model->asg_end_time);
                        $res = "";
                        if(!$model->isNewRecord){
                            $updated_at = new DateTime($model->updated_at);
                            $interval = $updated_at->diff($asg_end_time);
                            
                            $res = $interval->format("Di kirim %a hari, %h jam, %i menit lebih awal");
                        }else{
                            $now = new DateTime();
                            $interval = $asg_end_time->diff($now);
                            
                            $res = $interval->format("%a hari, %h jam, %i menit");
                        }
                        return $res;
                    }
                ],
                [
                    'attribute' => '',
                    'label' => 'Terakhir Modifikasi',
                    'format' => 'raw',
                    'value' => function($model){
                        $res = isset($assignment->updated_at) ? $assignment->updated_at : ' &nbsp;- - -';         
                        return $res;
                    }
                ],
            ],
        ]) ?>
        
    </div>

    <div class="col-md-6 form-project">
        <?php
            // $status = AssignmentController::getProject($assignment["asg_id"]);
            if($assignment->stsAsg->sts_asg_name == "Pending"){
                echo "<div class='alert alert-warning' style='border-left: 6px solid #FFA726;'>
                        <strong>Info!</strong> <br> Belum dapat submit proyek karena status penugasan masih pending
                    </div><br>";
            }
        ?>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'proj_title')->textInput(['readOnly' => false, 'maxlength' => true, 'style' => 'font-weight: 700']) ?>
        
        <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
            'options' => [
                'minHeight' => 500,
            ],
        ]) ?>
        
        <?= $form->field($model, 'proj_author')->textArea(['rows' => '3', 'maxLength' => true])->hint('Max 500 karakter.')->label("Penulis (Pisahkan Penulis dengan tanda titik koma [ ; ] )") ?>

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
                        if($assignment->sts_asg_id == 1){
                            echo "<p class='col-sm-5'>" . $file->file_name . "</p>";
                        }else{
                            echo "<p class='col-sm-12'>" . Html::a($file->file_name, ['download-attachment', 'file_id' => $file->file_id]) . "</p>";
                        }

                        if($assignment->sts_asg_id == 1){
                            echo "<p class='col-sm-7'>" . Html::a('-', ['remove-attachment', 'file_id' => $file->file_id], ['class' => 'btn btn-danger']) . "</p>";
                        }
                    }
                    echo("
                        </div>
                    ");
                }
            }
        ?>

        <?php
            if($assignment->sts_asg_id == 1){
                echo('
                    <div class="form-group">
                        <label>Upload Proyek</label>
                        <div class="row">
                            <div id="file_field" class="col-md-6">
                                <input type="file" class="form-control" name="files[]">
                            </div>
                            <a href="#" onclick="addMoreFile()">Add More File</a>
                        </div>
                    </div>
                ');
            }
        ?>

        <div class="form-group" align="center">
            <?php
                if($assignment->sts_asg_id == 1){
                    echo Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-succes' : 'btn btn-warning']).'&nbsp;&nbsp;';
                }
                
                echo Html::a("Kembali", ['assignment/assignment-student'], ['class' => 'btn btn-primary']);
            ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

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
