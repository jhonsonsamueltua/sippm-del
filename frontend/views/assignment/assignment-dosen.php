<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;

// $css = ['css/assignment.css'];

?>

<div class="body-content">
    <div class=" container box-content">
        <h3 class="text-title">Penugasan</h3>
        <hr class="hr-custom">
        
        <?= Html::a('Tambah Penugasan', ['assignment/create'], ['class' => 'btn-sm button btn-custom', 'style' => 'padding: 8px 30px;']) ?>
        <br><br>

        <div style="float: right; padding-right: 25px;">
            <?= Html::label( ('Page size: '), 'pagesize', array( 'style' => 'margin-left:10px; margin-top:8px;color: white; font-size: 15px;' ) ) ?>
            <?= Html::dropDownList(
                'pagesize', 
                ( isset($_GET['pagesize']) ? $_GET['pagesize'] : 20 ), 
                array( 
                    5 => 5, 
                    10 => 10, 
                    15 => 15,
                    20 => 20, 
                    25 => 25,
                    ),
                array( 
                    'id' => 'pagesize', 
                    'style' => 'margin-left:5px; margin-top:8px;'
                    )
                ) 
            ?>
        </div>
        
        <ul class="nav nav-tabs" style="background-color: #6AC7C1;">
            <li class="active"><a data-toggle="tab" href="#tab1">Penugasan saat ini <span class="badge"> <?= $modelPenugasanSaatIniCount ?> </span> </a></li>
            <li><a data-toggle="tab" href="#tab2">Riwayat Penugasan <span class="badge"> <?= $modelRiwayatPenugasanCount ?> </span> </a></li>
        </ul>

        <div class="tab-content">
            <div id="tab1" class="tab-pane fade in active">
        
                <?php
                    if($modelPenugasanSaatIniCount == 0){
                        echo '<br><p><i> &nbsp;&nbsp;Tidak ada penugasan saat ini.</i></p>';
                    }else{
                        foreach($modelPenugasanSaatIni as $key){
                            $asg_end_time = $key["asg_end_time"];
                            $asg_end_time_timestamp = strtotime($asg_end_time);
                            $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                            $asg_start_time = $key["asg_start_time"];
                            $asg_start_time_timestamp = strtotime($asg_end_time);
                            $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);?>
                            
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                    <span class="badge badge-primary badge-pill">
                                        <?= $key->stsAsg->sts_asg_name ?>
                                    </span>
                                    <div class="text-author">
                                    Batas Awal : <?= $asg_start_time?> <b> ; </b> Batas Akhir : <?= $asg_end_time?>
                                    <div style="float: right;">
                                        <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?> 
                                        <?= Html::a('| Edit', ['assignment/update', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?>
                                        <?= Html::a('| Hapus', ['assignment/delete', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?> 
                                    </div>
                                    </div>
                                </li>
                            </ul>
                <?php
                        }
                    }
                ?>
            </div>

            <div id="tab2" class="tab-pane fade">

                <table class="table table-hover" style="background-color: aliceblue">
                    <tbody>

                <?php
                    if($modelRiwayatPenugasanCount == 0){
                        echo '<br><p><i> &nbsp;&nbsp;Tidak ada riwayat penugasan.</i></p>';
                    }else{
                        // echo '<ul class="list-group">';
                        foreach($modelRiwayatPenugasan as $key){
                            $asg_end_time = $key["asg_end_time"];
                            $asg_end_time_timestamp = strtotime($asg_end_time);
                            $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                            $asg_start_time = $key["asg_start_time"];
                            $asg_start_time_timestamp = strtotime($asg_end_time);
                            $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);?>
                            
                            
                        <tr>
                            <td>
                                <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                <div class="text-author">
                                    Batas Awal : <?= $asg_start_time?> <b> ; </b> Batas Akhir : <?= $asg_end_time?>
                                </div>
                            </td>
                            <td>
                                <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']) ?> &nbsp;&nbsp; 
                                <?= Html::a('Open', ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'btn-xs btn-custom', 'style' => 'padding: 5px 20px;font-size: 13px']) ?>
                            </td>
                        </tr>

                                <!-- <li class="list-group-item d-flex justify-content-between align-items-center" style="border: 0px;">
                                    <?= Html::a($key["asg_title"], ['assignment/view', 'id' => $key["asg_id"]], ['class' => 'text-title-project']) ?> 
                                    <div style="float: right;">
                                        <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?> 
                                    </div>
                                    <div class="text-author">
                                    Batas Awal : <?= $asg_start_time?> <b> ; </b> Batas Akhir : <?= $asg_end_time?>
                                    </div>
                                </li> -->
                            
                <?php
                        }
                        // echo '</ul>';
                    }
                ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
