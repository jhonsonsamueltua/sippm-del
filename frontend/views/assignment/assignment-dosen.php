<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use frontend\controllers\AssignmentController;
use kartik\datetime\DateTimePicker;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;

// $css = ['css/assignment.css'];
?>
    

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css "> -->
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

        <h3> <b>Penugasan</b> </h3>
        <hr class="hr-custom">
        
        <?= Html::a('Tambah Penugasan', ['assignment/create'], ['class' => 'btn-sm button btn-custom', 'style' => 'padding: 8px 30px;']) ?>
        <br><br>

        <ul class="nav nav-tabs" style="background-color: #6AC7C1;">
            <li class="active"><a data-toggle="tab" href="#tab1"> <i class="fa fa-tasks" aria-hidden="true" style="color:#777777"></i> &nbsp; Penugasan saat ini <span class="badge"> <?= $modelPenugasanSaatIniCount ?> </span> </a></li>
            <li><a data-toggle="tab" href="#tab2"> <i class="fa fa-tasks" aria-hidden="true" style="color:#777777"></i> &nbsp; Riwayat Penugasan <span class="badge"> <?= $modelRiwayatPenugasanCount ?> </span> </a></li>
        </ul>

        <div class="tab-content">
            <div id="tab1" class="tab-pane fade in active">
                
                <!-- <h3 class=""><b><i class="fa fa-tasks" aria-hidden="true"></i> Penugasan Saat Ini <span class="badge"> <?= $modelPenugasanSaatIniCount ?> </span></b></h3> -->
                <br>
                <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Penugasan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($modelPenugasanSaatIniCount == 0){
                                // echo '<br><p><i> &nbsp;&nbsp;Tidak ada penugasan saat ini.</i></p>';
                            }else{
                                foreach($modelPenugasanSaatIni as $key){
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);?>

                                    <tr>
                                        <td>
                                            <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                            <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary badge-pill" style="float: right">
                                                Status : <?= $key->stsAsg->sts_asg_name ?>
                                            </span>
                                            <br>
                                            <div style="float: right; margin-bottom: 0px;">
                                                <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']) ?> 
                                                <?= Html::a('Edit', ['assignment/update', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-primary btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']) ?> 
                                                <?= Html::a('Hapus', ['assignment/delete', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-danger btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']) ?> 
                                            </div>
                                        </td>
                                    </tr>

                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>

            </div>

            <div id="tab2" class="tab-pane fade">
                
                <!-- <h3 class=""><b><i class="fa fa-tasks" aria-hidden="true"></i> Riwayat Penugasan <span class="badge"> <?= $modelRiwayatPenugasanCount ?> </span></b></h3> -->
                <br>
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Penugasan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($modelRiwayatPenugasanCount == 0){
                                // echo '<br><p><i> &nbsp;&nbsp;Tidak ada riwayat penugasan.</i></p>';
                            }else{
                                foreach($modelRiwayatPenugasan as $key){
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = date('l, d M Y, H :i', $asg_start_time_timestamp);?>
                                    
                                    
                                <tr>
                                    <td>
                                        <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                        <div class="text-author">
                                            Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="float: right; margin-bottom: 0px;">
                                            <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']) ?> 
                                            <?php 
                                                Modal::begin([
                                                    'header' => '<h2>Pilih Batas Akhir</h2>',
                                                    'toggleButton' => ['label' => 'Re-Open', 'class' => ['btn-xs btn-custom'], 'style' => ['padding: 5px 20px; font-size: 13px']],
                                                ]);
                                                    
                                                    $modelAsg = AssignmentController::findModel($key['asg_id']);    
                                                    $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['open-assignment', 'asg_id' => $modelAsg->asg_id])]);

                                                    echo $form->field($modelAsg, 'updated_end_time')->widget(DateTimePicker::class, [
                                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                                        'options' => ['placeholder' => 'Pilih batas akhir ...'],
                                                        'pluginOptions' => [
                                                            'autoclose'=>true,
                                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                                        ]
                                                    ]);

                                                    echo Html::submitButton('Re-Open Assignment');

                                                    ActiveForm::end();

                                                Modal::end();
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<?php
     $this->registerJs('
        $(function () {
            $("#dataTables").DataTable({
            "pageLength": 5,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });
        $(function () {
            $("#dataTable").DataTable({
            "pageLength": 5,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });
     ', $this::POS_END);
?>
