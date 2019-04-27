<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Assignment;
use yii\widgets\LinkPager;

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
?>
<div class="assignment-index">
<br>
    <h2 class="text-h2">Penugasan</h2>
    <hr class="hr-custom">
    
    <div style="float: right">
        <?= Html::label( ('Page size: '), 'pagesize', array( 'style' => 'margin-left:10px; margin-top:8px;' ) ) ?>
        <?= Html::dropDownList(
            'pagesize', 
            ( isset($_GET['pagesize']) ? $_GET['pagesize'] : 20 ),  // set the default value for the dropdown list
            // set the key and value for the drop down list
            array( 
                5 => 5, 
                10 => 10, 
                15 => 15,
                20 => 20, 
                25 => 25,
                ),
            // add the HTML attritutes for the dropdown list
            // I add pagesize as an id of dropdown list. later on, I will add into the Gridview widget.
            // so when the form is submitted, I can get the $_POST value in InvoiceSearch model.
            array( 
                'id' => 'pagesize', 
                'style' => 'margin-left:5px; margin-top:8px;'
                )
            ) 
        ?>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Penugasan saat ini <span class="badge"> <?= $modelPenugasanSaatIniCount ?> </span> </a></li>
        <li><a data-toggle="tab" href="#tab2">Riwayat Penugasan <span class="badge"> <?= $modelRiwayatPenugasanCount ?> </span> </a></li>
    </ul>

    <div class="tab-content">
        <div id="tab1" class="tab-pane fade in active">
            <ul class="list-group">

                <?php
                if($modelPenugasanSaatIniCount == 0){
                    echo '<br><p><i> &nbsp;&nbsp;Tidak ada penugasan saat ini.</i></p>';
                }else{
                    foreach($modelPenugasanSaatIni as $key){
                        $submission = $this->context->getProject($key["asg_id"]);
                        $asg_end_time = $key["asg_end_time"];
                        $asg_end_time_timestamp = strtotime($asg_end_time);
                        $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                        $asg_start_time = $key["asg_start_time"];
                        $asg_start_time_timestamp = strtotime($asg_end_time);
                        $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);

                        $category = "Isi Nama Matkul atau kategori lainnya";
                        if($key['cat_proj_id'] == 1){
                            // $category = $key->course->course_name;
                        }else{
                            // $category = $key->catProj->cat_proj_name;
                        }
                        ?>
                        
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php
                                    if(!$submission == false){?>
                                        <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title']) ?> 
                                    <?php }else{ ?>
                                        <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title']) ?> 
                                <?php
                                    }
                                ?>
                            <span class="badge badge-primary badge-pill">
                                <?= $this->context->getStatusAssignment($key['asg_id']); ?>
                            </span>
                            
                            <br>
                            <font style="color: #777777;">Batas Awal : <?= $asg_start_time?> ; Batas Akhir : <?= $asg_end_time?> ; Oleh : <?= $key["asg_creator"]?> </font>
                            <span class="badge badge-primary badge-pill">
                                <?php
                                    if(!$submission == false){
                                        echo "Sudah submit";
                                    }else{
                                        echo "Belum submit";
                                    }
                                ?>
                            </span>
                            </li>
                        
                <?php
                        }
                        // echo LinkPager::widget([
                        //     'pagination' => $pagination,
                        // ]);
                    }
                ?>
                
            </ul>
        </div>
        <div id="tab2" class="tab-pane fade">
            <ul class="list-group">
            <?php
                if($modelRiwayatPenugasanCount == 0){
                    echo '<br><p><i> &nbsp;&nbsp;Tidak ada riwayat penugasan.</i></p>';
                }else{
                foreach($modelRiwayatPenugasan as $key){
                    $submission = $this->context->getProject($key["asg_id"]);
                    $old_date = $key["asg_end_time"];
                    $old_date_timestamp = strtotime($old_date);
                    $new_date = date('l, d M Y, H:i', $old_date_timestamp);
                    $category = "Isi Nama Matkul atau kategori lainnya";
                        if($key['cat_proj_id'] == 1){
                            // $category = $key->course->course_name;
                        }else{
                            // $category = $key->catProj->cat_proj_name;
                        }
                    ?>
                    
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php
                                if(!$submission == false){?>
                                    <?= Html::a($key["asg_title"], ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title']) ?> 
                                <?php }else{ ?>
                                    <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title']) ?> 
                            <?php
                                }
                            ?>
                        <br>
                        <font style="color: #777777;">Batas Akhir : <?= $new_date?>, Oleh : <?= $key["asg_creator"]?> </font>
                        </li>
                    
            <?php
                    }
                    // echo LinkPager::widget([
                    //     'pagination' => $pagination,
                    // ]);
                }
            ?>
            </ul>
        <div>
    </div>
</div>