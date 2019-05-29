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
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
// $this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);

?>
<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

        <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</i>\n",
                'links' => [
                    'Penugasan',
                ],
            ]);
        ?>
        <br>

        <h4> <b>Penugasan</b> </h4>
        <hr class="hr-custom">
        
        <div class="row">
            <div class="col-md-3" style="padding-bottom: 20px;">
                <?= Html::a('Tambah Penugasan', ['assignment/create'], ['class' => 'btn-md btn-custom', 'style' => 'padding: 8px 45px;font-size: 16px']) ?>
                <br><br>
                <div class="tab" style="margin-top: 0px;">
                    <button class="tab-head" > <b> Penugasan Anda</b> </button>
                    <button class="tablinks" onclick="openContent(event, 'now')" id="defaultOpen">Sedang Berlangsung &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelPenugasanSaatIniCount ?></span></button>
                    <button class="tablinks" onclick="openContent(event, 'wait')">Menunggu &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelMenungguCount ?></span></button>
                    <button class="tablinks" onclick="openContent(event, 'history')">Riwayat &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRiwayatPenugasanCount ?></span></button>
                </div>
            </div>
            <div class="col-md-9">
                <div id="now" class="tabcontent">
                    <table class="table table-hover table-responsive" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Penugasan Sedang Berlangsung</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php   
                                if($modelPenugasanSaatIniCount == 0){
                                    echo '<tr><td colspan=2 style="border-top: 0px;text-align: center"><i><br> Tidak ada penugasan saat ini. </i></td></tr>';
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
                                                <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key->catProj->cat_proj_name ?> - <?= $key->subCatProj->sub_cat_proj_name ?> , <?= $key->asg_year ?> </b></font>
                                                <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?>  &nbsp;-&nbsp;  <?= $asg_end_time?>
                                                </div>
                                            </td>
                                            <td style="padding: 25px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                                
                                                <div style="float: right; margin-bottom: 0px;">
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#FFA726;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#009688;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <br><br>
                                                    <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Ubah', ['assignment/update', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Batal', ['assignment/delete', 'id' => $key["asg_id"]], [
                                                        'class' => 'btn-md btn-danger btn-info-custom', 
                                                        'style' => 'padding: 5px 15px;',
                                                        'data' => [
                                                            'confirm' => 'Apakah anda yakin membatalkan penugasan ini?',
                                                            'method' => 'post',
                                                        ]
                                                    ]) ?>
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

                <div id="wait" class="tabcontent">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Penugasan Menunggu Dibuka</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php   
                                if($modelMenungguCount == 0){
                                    echo '<tr><td colspan=2 style="border-top: 0px;text-align: center"><i ><br> Tidak ada penugasan. </i></td></tr>';
                                }else{
                                    foreach($modelMenunggu as $key){
                                        $asg_end_time = $key["asg_end_time"];
                                        $asg_end_time_timestamp = strtotime($asg_end_time);
                                        $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                        $asg_start_time = $key["asg_start_time"];
                                        $asg_start_time_timestamp = strtotime($asg_start_time);
                                        $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>

                                        <tr>
                                            <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                                <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key->catProj->cat_proj_name ?> - <?= $key->subCatProj->sub_cat_proj_name ?> , <?= $key->asg_year ?> </b></font>
                                                <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?>  &nbsp;-&nbsp;  <?= $asg_end_time?>
                                                </div>
                                            </td>
                                            <td style="padding: 25px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                                
                                                <div style="float: right; margin-bottom: 0px;">
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#FFA726;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#009688;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <br><br>
                                                    <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Ubah', ['assignment/update', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Batal', ['assignment/delete', 'id' => $key["asg_id"]], [
                                                        'class' => 'btn-md btn-danger btn-info-custom', 
                                                        'style' => 'padding: 5px 15px;',
                                                        'data' => [
                                                            'confirm' => 'Apakah anda yakin membatalkan penugasan ini?',
                                                            'method' => 'post',
                                                        ]
                                                    ]) ?>
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

                <div id="history" class="tabcontent">
                    <table class="table table" id="dataTable3" width="100%" cellspacing="0">
                        <thead >
                        <tr>
                            <th>Riwayat Penugasan</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($modelRiwayatPenugasanCount == 0){
                                    echo '<tr><td colspan=2 style="border-top: 0px;text-align: center"><br><i> Tidak ada penugasan. </i></td></tr>';
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
                                                <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key->catProj->cat_proj_name ?> - <?= $key->subCatProj->sub_cat_proj_name ?> , <?= $key->asg_year ?> </b></font>
                                                <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?>  &nbsp;-&nbsp;  <?= $asg_end_time?>
                                                </div>
                                            </td>
                                            <td style="padding: 20px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                                
                                                <div style="float: right; margin-bottom: 0px;">
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Cancel"){
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#bb4441;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge badge-primary badge-pill" style="float: ;background-color:#8a6d3b;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <!-- <br><br>
                                                    <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Ubah', ['assignment/update', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <?= Html::a('Batal', ['assignment/delete', 'id' => $key["asg_id"]], [
                                                        'class' => 'btn-md btn-danger btn-info-custom', 
                                                        'style' => 'padding: 5px 15px;',
                                                        'data' => [
                                                            'confirm' => 'Apakah anda yakin ingin membatalkan penugasan berikut?',
                                                            'method' => 'post',
                                                        ]
                                                    ]) ?> &nbsp; -->
                                                    
                                                    <br><br>
                                                    <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-md btn-info btn-info-custom', 'style' => 'padding: 5px 15px;']) ?> &nbsp;
                                                    <!-- <font style="text-align: center">
                                                        <?php 
                                                            Modal::begin([
                                                                'header' => '<h3>Re-Open Penugasan</h3>',
                                                                'toggleButton' => ['label' => 'Re-Open', 'class' => 'btn btn-primary btn-info-custom', 'style' => 'padding: 4px 15px; margin-bottom: 1px;border: 0px;'],
                                                                'size' => 'modal-md',
                                                            ]);
                                                                
                                                                $modelAsg = AssignmentController::findModel($key['asg_id']);    
                                                                $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['open-assignment', 'asg_id' => $modelAsg->asg_id])]);

                                                                echo $form->field($modelAsg, 'updated_end_time')->widget(DateTimePicker::class, [
                                                                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                                                    'pickerIcon' => '<i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 19px;color: #64B5F6"></i>',
                                                                    'removeButton' => false,
                                                                    'options' => ['placeholder' => 'Pilih batas akhir...',
                                                                    'autocomplete'=>'off'],
                                                                    'pluginOptions' => [
                                                                        'autoclose'=>true,
                                                                        'format' => 'yyyy-mm-dd hh:ii:ss'
                                                                    ]
                                                                ])->label('Batas Akhir &nbsp;&nbsp;');
                                                                
                                                                echo '<br><br>';
                                                                echo Html::submitButton('Re-Open', ['class' => 'btn btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;border: 0px;']).'&nbsp;&nbsp;';
                                                                echo '&nbsp;&nbsp;'.Html::a("Batal", [''], ['data-dismiss' => 'modal', 'class' => 'btn btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;border: 0px;']);

                                                                ActiveForm::end();

                                                            Modal::end();
                                                        ?>
                                                    </font> -->
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
</div>

<?php
     $this->registerJs('
     
        $(function () {
            $("#dataTables").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });
        
        $(function () {
            $("#dataTable").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });

        $(function () {
            $("#dataTable3").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });

        $("form").submit(function(event){
            var value = $("#assignment-updated_end_time").val();
            
            if(value == ""){
                event.preventDefault();
                $(".field-assignment-updated_end_time").addClass("has-error");
                $(".field-assignment-updated_end_time").removeClass("has-success");
                $(".field-assignment-updated_end_time").find($(".help-block")).html("Batas Akhir tidak boleh kosong");
            }
        });

        function openContent(evt, contentName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(contentName).style.display = "block";
            evt.currentTarget.className += " active";
          }
          
          // Get the element with id="defaultOpen" and click on it
          document.getElementById("defaultOpen").click();
     ', $this::POS_END);
?>
