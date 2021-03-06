<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Assignment;
use yii\widgets\LinkPager;
use frontend\controllers\SiteController;
use yii\widgets\Breadcrumbs;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("././css/assignment.css");
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>


<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">   
        
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
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
                <div class="tab" style="margin-top: 0px;">
                    <button class="tab-head" > <b> Penugasan Anda</b> </button>
                    <button class="tablinks" onclick="openContent(event, 'now')" id="defaultOpen">Sedang Berlangsung &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelPenugasanSaatIniCount ?></span></button>
                    <button class="tablinks" onclick="openContent(event, 'wait')">Menunggu &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelMenungguCount ?></span></button>
                    <button class="tablinks" onclick="openContent(event, 'history')">Riwayat &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRiwayatPenugasanCount ?></span></button>
                </div>
            </div>
            <div class="col-md-9">
                <div id="now" class="tabcontent">
                    <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Penugasan Sedang Berlangsung</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($modelPenugasanSaatIniCount == 0){
                                    echo '<tr><td colspan=2 style="text-align: center"><i> <br>Tidak ada penugasan saat ini. </i></td></tr>';
                                }else{
                                    foreach($modelPenugasanSaatIni as $key){
                                        $submission = $this->context->getProject($key["asg_id"]);
                                        $asg_end_time = $key["asg_end_time"];
                                        $asg_end_time_timestamp = strtotime($asg_end_time);
                                        $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                        $asg_start_time = $key["asg_start_time"];
                                        $asg_start_time_timestamp = strtotime($asg_start_time);
                                        $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>

                                        <tr>
                                            <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                            <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key['cat_proj_name'] ?> - <?= $key['sub_cat_proj_name'] ?> , <?= $key['asg_year'] ?> </b></font>
                                            <!-- <font class='text-category'> <?= $key['cat_proj_name'].' [ '.$key['sub_cat_proj_name'].' ]' ?> </font> <br> -->
                                                <?php
                                                    if(!$submission == false){?>
                                                        <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                    <?php }else{ ?>
                                                        <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <?php
                                                    }
                                                ?>
                                                <div class="text-author">
                                                    Waktu Penugasan : <?= $asg_start_time?> &nbsp;-&nbsp; <?= $asg_end_time?> ; Oleh : <?= $key['asg_creator'] ?>
                                                </div>
                                            </td>
                                            <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;position: relative;">
                                                <font><br>
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                            echo '<span class="badge " style="background-color:#FFA726;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge " style="background-color:#009688;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <br>
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) != "Pending"){
                                                            if(!$submission == false){
                                                                echo "<span class='badge ' style='background-color: #4CAF50'>Sudah submit</span>";
                                                            }else{
                                                                echo "<span class='badge ' style='background-color: #E65100'>Belum submit</span>";
                                                            }
                                                        }
                                                    ?>
                                                        
                                                </font>
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
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($modelMenungguCount == 0){
                                    echo '<tr><td colspan=2 style="text-align: center"><i> <br> Tidak ada penugasan saat ini. </i></td></tr>';
                                }else{
                                    foreach($modelMenunggu as $key){
                                        $submission = $this->context->getProject($key["asg_id"]);
                                        $asg_end_time = $key["asg_end_time"];
                                        $asg_end_time_timestamp = strtotime($asg_end_time);
                                        $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                        $asg_start_time = $key["asg_start_time"];
                                        $asg_start_time_timestamp = strtotime($asg_start_time);
                                        $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>

                                        <tr>
                                            <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;">
                                            <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key['cat_proj_name'] ?> - <?= $key['sub_cat_proj_name'] ?> , <?= $key['asg_year'] ?> </b></font>
                                                <?php
                                                    if(!$submission == false){?>
                                                        <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                    <?php }else{ ?>
                                                        <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <?php
                                                    }
                                                ?>
                                                <div class="text-author">
                                                    Waktu Penugasan : <?= $asg_start_time?> &nbsp;-&nbsp; <?= $asg_end_time?>; Oleh : <?= $key['asg_creator'] ?>
                                                </div>
                                            </td>
                                            <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;position: relative;">
                                                <font><br>
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                            echo '<span class="badge " style="background-color:#FFA726;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge " style="background-color:#009688;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <br>
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) != "Pending"){
                                                            if(!$submission == false){
                                                                echo "<span class='badge ' style='background-color: #4CAF50'>Sudah submit</span>";
                                                            }else{
                                                                echo "<span class='badge ' style='background-color: #E65100'>Belum submit</span>";
                                                            }
                                                        }
                                                    ?>
                                                        
                                                </font>
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
                    <table class="table table-hover" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Riwayat Penugasan</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($modelRiwayatPenugasanCount == 0){
                                    echo '<tr><td colspan=2> <br> Tidak ada riwayat penugasan. </td></tr>';
                                }else{
                                    foreach($modelRiwayatPenugasan as $key){
                                        $submission = $this->context->getProject($key["asg_id"]);
                                        $asg_end_time = $key["asg_end_time"];
                                        $asg_end_time_timestamp = strtotime($asg_end_time);
                                        $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);  

                                        $asg_start_time = $key["asg_start_time"];
                                        $asg_start_time_timestamp = strtotime($asg_start_time);
                                        $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);  ?>
                                        
                                        
                                    <tr>
                                        <td style="padding: 15px 8px;">
                                            <font style="font-size: px;margin: 3px 0px;display: block;color: #616161;"> <b> <?= $key['cat_proj_name'] ?> - <?= $key['sub_cat_proj_name'] ?> , <?= $key['asg_year'] ?> </b></font>
                                            <?php
                                                if(!$submission == false){?>
                                                    <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                                <?php }else{ ?>
                                                    <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-weight: 700']) ?> 
                                            <?php
                                                }
                                            ?>
                                            <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?> &nbsp;-&nbsp; <?= $asg_end_time?>; oleh : <?= $key['asg_creator'] ?>
                                            </div>
                                        </td>
                                        <td style="padding: 15px 8px;border-bottom: 1px solid #ddd;border-top: none;position: relative;">
                                            <font><br>
                                                    <?php
                                                        if($this->context->getStatusAssignment($key['asg_id']) == "Pending"){
                                                            echo '<span class="badge " style="background-color:#FFA726;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }else{
                                                            echo '<span class="badge " style="background-color:#009688;margin-bottom: 5px;">
                                                                Status : '.$this->context->getStatusAssignment($key["asg_id"]).'
                                                            </span>';
                                                        }
                                                    ?>
                                                    <br>
                                                    <?php
                                                        if(!$submission == false){
                                                            echo "<span class='badge ' style='background-color: #4CAF50'>Sudah submit</span>";
                                                        }else{
                                                            if($key['cat_proj_name'] == "Kompetisi"){
                                                                echo "<span class='badge ' style='background-color: #E65100'>Tidak Ikut Kompetisi</span>";
                                                            }else{
                                                                echo "<span class='badge ' style='background-color: #E65100'>Tidak Submit</span>";
                                                            }
                                                        }
                                                    ?>
                                                        
                                                </font>
                                            <div>
                                                    <!-- <?php
                                                        if(!$submission == false){
                                                            echo "<span class='badge center-badge' style='background-color: #4CAF50'>Sudah submit</span>";
                                                        }else{
                                                            echo "<span class='badge center-badge' style='background-color: #E65100'>Tidak submit</span>";
                                                        }
                                                    ?> -->
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
            "pageLength": 5,
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
            "pageLength": 5,
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
            "pageLength": 5,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
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
