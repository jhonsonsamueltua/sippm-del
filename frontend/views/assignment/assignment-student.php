<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Assignment;
use yii\widgets\LinkPager;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
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
                                    $submission = $this->context->getProject($key["asg_id"]);
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);?>

                                    <tr>
                                        <td>
                                            <?php
                                                if(!$submission == false){?>
                                                    <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project']) ?>
                                                <?php }else{ ?>
                                                    <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project']) ?>
                                            <?php
                                                }
                                            ?>
                                            <div class="text-author">
                                                Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>, Oleh : <?= $key['asg_creator'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary badge-pill" style="float: right">
                                                Status : <?= $this->context->getStatusAssignment($key['asg_id']); ?>
                                            </span>
                                            <br>
                                            <div style="float: right; margin-bottom: 0px;">
                                                <span class="badge badge-primary badge-pill">
                                                    <?php
                                                        if(!$submission == false){
                                                            echo "Sudah submit";
                                                        }else{
                                                            echo "Belum submit";
                                                        }
                                                    ?>
                                                </span>
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
                                    $submission = $this->context->getProject($key["asg_id"]);
                                    $asg_end_time = $key["asg_end_time"];
                                    $asg_end_time_timestamp = strtotime($asg_end_time);
                                    $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                                    $asg_start_time = $key["asg_start_time"];
                                    $asg_start_time_timestamp = strtotime($asg_start_time);
                                    $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);?>
                                    
                                    
                                <tr>
                                    <td>
                                        <?php
                                            if(!$submission == false){?>
                                                <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title-project']) ?> 
                                            <?php }else{ ?>
                                                <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                        <?php
                                            }
                                        ?>
                                        <div class="text-author">
                                            Waktu Penugasan : <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="float: right; margin-bottom: 0px;">
                                            <span class="badge badge-primary badge-pill">
                                                <?php
                                                    if(!$submission == false){
                                                        echo "Sudah submit";
                                                    }else{
                                                        echo "Tidak submit";
                                                    }
                                                ?>
                                            </span>
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
