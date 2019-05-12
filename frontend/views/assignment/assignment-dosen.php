<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use frontend\controllers\AssignmentController;
use kartik\datetime\DateTimePicker;
use frontend\controllers\SiteController;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("././css/assignment.css");
?>

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script> -->

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

        <div class="row" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        'Penugasan',
                    ],
                ]);
            ?>
        </div>

        <h3> <b>Penugasan</b> </h3>
        <hr class="hr-custom">
        
        <?= Html::a('Tambah Penugasan', ['assignment/create'], ['class' => 'btn-md btn-custom', 'style' => 'padding: 8px 30px;']) ?>
        <br><br>

        <ul class="nav nav-tabs" style="background-color: #6AC7C1;">
            <li class="active"><a data-toggle="tab" href="#tab1"> <i class="fa fa-tasks" aria-hidden="true" style="color:#777777"></i> &nbsp; Penugasan Anda <span class="badge"> <?= $modelPenugasanSaatIniCount ?> </span> </a></li>
            <li><a data-toggle="tab" href="#tab2"> <i class="fa fa-tasks" aria-hidden="true" style="color:#777777"></i> &nbsp; Riwayat Penugasan <span class="badge"> <?= $modelRiwayatPenugasanCount ?> </span> </a></li>
        </ul>

        <div class="tab-content">
            <div id="tab1" class="tab-pane fade in active">
                <br>
                <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                    <thead hidden>
                    <tr>
                        <th>Penugasan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php   
                            if($modelPenugasanSaatIniCount == 0){
                                echo '<tr><td colspan=2 style="border-top: 0px;"><i> Tidak ada penugasan saat ini. </i></td></tr>';
                            }else{
                                foreach($modelPenugasanSaatIni as $key){
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>

                                    <tr>
                                        <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                            <font class='text-category'> <?= $key->catProj->cat_proj_name.' [ '.$key->subCatProj->sub_cat_proj_name.' ]' ?> </font> <br>
                                            <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                            <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>
                                            </div>
                                        </td>
                                        <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                            <?php
                                                if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                    echo '<span class="badge badge-primary badge-pill" style="float: right;background-color:#FFA726;">
                                                        Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                    </span>';
                                                }else{
                                                    echo '<span class="badge badge-primary badge-pill" style="float: right;background-color:#009688;">
                                                        Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                    </span>';
                                                }
                                            ?>
                                            <br><br>
                                            <div style="float: right; margin-bottom: 0px;">
                                                <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                <?= Html::a('Edit', ['assignment/update', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                <?= Html::a('Hapus', ['assignment/delete', 'id' => $key["asg_id"]], [
                                                        'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;',
                                                        'data' => [
                                                            'confirm' => 'Hapus penugasan ini?',
                                                            'method' => 'post',
                                                        ],
                                                ]) ?> &nbsp;
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
                                echo '<tr><td colspan=2 style="border-top: 0px;"><i> Tidak ada penugasan saat ini. </i></td></tr>';
                            }else{
                                foreach($modelRiwayatPenugasan as $key){
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>
                                    
                                    
                                <tr>
                                    <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                        <font class='text-category'> <?= $key->catProj->cat_proj_name.' [ '.$key->subCatProj->sub_cat_proj_name.' ]' ?> </font> <br>
                                        <?= Html::a($key->catProj->cat_proj_name.''.$key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                        <div class="text-author">
                                            Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>
                                        </div>
                                    </td>
                                    <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                        <div style="float: right;text-align: center;">
                                            <br>
                                            <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                            
                                            <?php 
                                                Modal::begin([
                                                    'header' => '<h3>Re-Open Penugasan</h3>',
                                                    'toggleButton' => ['label' => 'Re-Open', 'class' => 'btn btn-primary btn-info-custom', 'style' => 'padding: 4px 15px; margin-bottom: 1px;border: 0px;border-radius: 0px!important;'],
                                                ]);
                                                    
                                                    $modelAsg = AssignmentController::findModel($key['asg_id']);    
                                                    $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['open-assignment', 'asg_id' => $modelAsg->asg_id])]);

                                                    echo $form->field($modelAsg, 'updated_end_time')->widget(DateTimePicker::class, [
                                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 19px;color: #64B5F6"></i>',
                                                        'removeIcon' => '<i class="fa fa-calendar-times-o" aria-hidden="true" style="font-size: 19px;color: #FF8A65"></i>',
                                                        'options' => ['placeholder' => 'Pilih batas akhir ...'],
                                                        'pluginOptions' => [
                                                            'autoclose'=>true,
                                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                                        ]
                                                    ])->label('Batas Akhir &nbsp;&nbsp;');
                                                    
                                                    echo '<br><br>';
                                                    echo Html::submitButton('Re-Open', ['class' => 'btn btn-sm btn-primary', 'style' => 'padding: 5px 25px;width: 120px;font-style: bold;font-size:14px']);

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
            "lengthChange": false,
            "searching": false,
            "ordering": false,
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
