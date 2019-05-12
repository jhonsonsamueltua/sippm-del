<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\StatusWin;
use common\models\CategoryProject;
use common\models\Project;
use frontend\controllers\AssignmentController;
use yii\widgets\DetailView;
use frontend\controllers\SiteController;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("././css/project.css");
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<div class="row">

    <div class="col-md-6" style="padding: 0px 25px;">
        <h3 style="margin-top:0px"><b style="font-size: 18px">Penugasan</b></h3>
        <hr class="hr-custom">
        <b style="display:block;margin-bottom:5px;"><?= $assignment->catProj->cat_proj_name ?> [ <?= $assignment->subCatProj->sub_cat_proj_name ?> ] </b>
        <font class="text-title-asg"><?= $assignment->asg_title ?></font>
        
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
                    'attribute' => 'asg_creator',
                    'label' => 'Koordinator Proyek',
                ],
                [
                    'attribute' => '',
                    'label' => 'Batas Waktu',
                    'value' => function($model){
                        $old_date = $model->asg_end_time;

                        $date_timestamp = strtotime($old_date);
                        return SiteController::tgl_indo(date('Y-m-d', $date_timestamp)).', '.date('H:i:s', $date_timestamp);
                    }
                ],
                [
                    'attribute' => '',
                    'label' => 'Waktu tersisa',
                    'value' => function($model){
                        // $session = Yii::$app->session;
                        // $project = Project::find()->where(['asg_id' => $model->asg_id])->andWhere(['created_by' => $session['username']])->andWhere('deleted != 1')->one();
                        date_default_timezone_set("Asia/Bangkok");
                        $asg_end_time = new \DateTime($model->asg_end_time);
                        $res = "";

                        $session = Yii::$app->session;
                        $project = Project::find()->where(['asg_id' => $model->asg_id])->andWhere(['created_by' => $session['username']])->andWhere('deleted != 1')->one();
                        $status = AssignmentController::getProject($model["asg_id"]);
                        
                        if($status == true){
                            $updated_at = new \DateTime($project->updated_at);
                            $interval = $updated_at->diff($asg_end_time);
                            
                            if($interval->format("%a") <= 0 && $interval->format("%h") <= 0){
                                $res = $interval->format("Dikirim %i menit, %s detik lebih awal");
                            }elseif($interval->format("%a") <= 0 && $interval->format("%i") > 0){
                                $res = $interval->format("Dikirim %h jam, %i menit, %s detik lebih awal");
                            }else{
                                $res = $interval->format("Dikirim %a hari, %h jam, %i menit, %s detik lebih awal");
                            }
                        }else{
                            
                            $now = new DateTime();
                            $interval = $asg_end_time->diff($now);

                            if($now > new DateTime($model->asg_end_time)){
                                if($interval->format("%a") <= 0 && $interval->format("%h") <= 0){
                                    $res = $interval->format("Terlambat %I : %S");
                                }elseif($interval->format("%a") <= 0){
                                    $res = $interval->format("Terlambat %H : %I : %S");
                                }else{
                                    $res = $interval->format("Terlambat %a hari, %H : %I : %S");
                                }
                            }else{
                                if($interval->format("%a") <= 0 && $interval->format("%h") <= 0){
                                    $res = $interval->format("Tersisa %I : %S");
                                }elseif($interval->format("%a") <= 0){
                                    $res = $interval->format("Tersisa %H : %I : %S");
                                }else{
                                    $res = $interval->format("Tersisa %a hari, %H : %I : %S");
                                }
                            }
                        }
                        return $res;
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'label' => 'Terakhir Modifikasi',
                    'format' => 'raw',
                    'value' => function($model){
                        $session = Yii::$app->session;
                        $project = Project::find()->where(['asg_id' => $model->asg_id])->andWhere(['created_by' => $session['username']])->andWhere('deleted != 1')->one();
                        $res = '---';
                        if(isset($project)){
                            $updated_at = $project->updated_at;

                            $date_timestamp = strtotime($updated_at);
                            $res = SiteController::tgl_indo(date('Y-m-d', $date_timestamp)).', '.date('H:i:s', $date_timestamp);
                        }
                        

                        return $res;
                    }
                ],
            ],
        ]) ?>
        
    </div>

    <div class="col-md-6 form-project">
        <h3 style="margin-top:0px"><b style="font-size: 18px">Proyek</b></h3>
        <hr class="hr-custom">
        <?php
            $status = AssignmentController::getProject($assignment["asg_id"]);
            if($assignment->stsAsg->sts_asg_name == "Pending"){
                echo "<div class='alert alert-warning' style='border-left: 6px solid #FFA726;'>
                        <strong>Info!</strong> <br> Belum dapat submit proyek karena status penugasan masih pending.
                    </div><br>";
            }elseif($status == false && $assignment->stsAsg->sts_asg_name == "Close"){
                echo "<div class='alert alert-danger' style='border-left: 6px solid #FF7043;'>
                        <strong>Info!</strong> <br>Maaf, penugasan telah di tutup. Anda tidak dapat lagi mengirim proyek sampai koordinator membuka kembali.
                    </div><br>";
            }elseif($late == true){
                echo "<div class='alert alert-danger' style='border-left: 6px solid #FF7043;'>
                        <strong>Info!</strong> <br>Maaf, tidak dapat mengubah proyek karena penugasan telah di tutup.
                    </div><br>";
            }
        ?>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <!-- <?= $form->field($model, 'proj_title')->textInput(['readOnly' => false, 'maxlength' => true, 'style' => 'font-weight: 700']) ?> -->

        <?= $form->field($model, 'proj_title')->textArea(['rows' => '3', 'maxLength' => true, 'style' => 'font-weight: 700']) ?>
        
        <?= $form->field($model, 'proj_description')->widget(Redactor::classname(), [
            'options' => [
                'minHeight' => 500,
            ],
        ]) ?>
        
        <?= $form->field($model, 'proj_author')->textArea(['rows' => '3', 'maxLength' => true, 'placeholder' => 'Contoh : Nama Anda; Nama Teman Anda'])->hint('Max 500 karakter.')->label("Penulis (Pisahkan Penulis dengan tanda titik koma [ ; ] )")?>

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
                            echo '<div class="row">';
                            echo "<p class='col-sm-1'>" . Html::a('-', ['remove-attachment', 'file_id' => $file->file_id], ['class' => 'btn btn-danger-custom btn-sm', 'style' => 'padding: 0px 10px 5px;; font-size:20px;display: unset',"data" => [
                                "confirm" => "Apakah anda yakin menghapus file ini?",
                                "method" => "post",
                            ]]) . "</p>";
                            echo "<p class='col-sm-11' style='margin: 0px;padding: 10px;'>" . $file->file_name . "</p>";
                            echo '</div>';
                        }else{
                            echo "<p class='col-sm-12'>" . Html::a($file->file_name, ['download-attachment', 'file_id' => $file->file_id]) . "</p>";
                            echo "<br>";
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
                            <a href="#" onclick="addMoreFile()">Tambah File</a>
                        </div>
                    </div>
                ');
            }
        ?>

        <div class="form-group" align="center">
            <?php
                echo '<br><br>';
                if($assignment->sts_asg_id == 1){
                    echo Html::submitButton($model->isNewRecord ? 'Kirim &nbsp;<i style="font-size:16px" class="fa fa-paper-plane" aria-hidden="true"></i>' : 'Edit &nbsp;<i style="font-size:16px" class="far fa-edit"></i> ', ['class' => $model->isNewRecord ? 'btn-md btn-custom' : 'btn-md btn-custom btn-primary-edit', 'style' => 'padding: 8px 25px;width: 150px;']).'&nbsp;&nbsp;';
                }
                
                if($assignment->sts_asg_id == 3 || $assignment->sts_asg_id == 2 || !$model->isNewRecord){
                    echo '&nbsp;&nbsp;'.Html::a("Kembali &nbsp;<i class='fa fa-arrow-left' aria-hidden='true' style='font-size:16px'></i>
                    ", ['assignment/assignment-student'], ['class' => 'btn-md btn-custom btn-primary-edit-kembali', 'style' => 'padding: 8px 25px;width: 150px;']);
                }
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
