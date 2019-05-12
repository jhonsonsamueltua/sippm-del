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
?>

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

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
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($modelPenugasanSaatIniCount == 0){
                                echo '<tr><td colspan=2><i> Tidak ada penugasan saat ini. </i></td></tr>';
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
                                        <font class='text-category'> <?= $key['cat_proj_name'].' [ '.$key['sub_cat_proj_name'].' ]' ?> </font> <br>
                                            <?php
                                                if(!$submission == false){?>
                                                    <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project', 'style' => 'font-size:20px']) ?>
                                                <?php }else{ ?>
                                                    <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-size:20px']) ?>
                                            <?php
                                                }
                                            ?>
                                            <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>, Oleh : <?= $key['asg_creator'] ?>
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

            <div id="tab2" class="tab-pane fade">
                
                <br>
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Penugasan</th>
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
                                    <font class='text-category'> <?= $key['cat_proj_name'].' [ '.$key['sub_cat_proj_name'].' ]' ?> </font> <br>
                                        <?php
                                            if(!$submission == false){?>
                                                <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project', 'style' => 'font-size:20px']) ?>
                                            <?php }else{ ?>
                                                <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project', 'style' => 'font-size:20px']) ?>
                                        <?php
                                            }
                                        ?>
                                        <div class="text-author">
                                            Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?> ; oleh : <?= $key['asg_creator'] ?>
                                        </div>
                                    </td>
                                    <td style="padding: 15px 8px;position: relative;">
                                        <div>
                                                <?php
                                                    if(!$submission == false){
                                                        echo "<span class='badge center-badge' style='background-color: #4CAF50'>Sudah submit</span>";
                                                    }else{
                                                        echo "<span class='badge center-badge' style='background-color: #E65100'>Tidak submit</span>";
                                                    }
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
