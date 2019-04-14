<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Assignment;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// echo '<pre>';
// var_dump($model);die();
$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
?>
<div class="assignment-index">
<br>
    <h2 class="text-h2">Penugasan saat ini</h2>
    <hr class="hr-custom">
    
    <?php
        foreach($model as $key){
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
            if($key["sts_asg_id"] == 1){?>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php
                        if(!$submission == false){?>
                            <?= Html::a($key["asg_title"].' [ '.$category.' ] ', ['project/update', 'id' => $submission->proj_id], ['class' => 'text-title']) ?> 
                        <?php }else{ ?>
                            <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['class' => 'text-title']) ?> 
                    <?php
                        }
                    ?>
                <span class="badge badge-primary badge-pill">
                    <?php
                        if(!$submission == false){
                            echo "Sudah submit";
                        }else{
                            echo "Belum submit";
                        }
                    ?>
                </span>
                <br>
                <font style="color: #777777;">Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?> </font>
                </li>
            </ul>
    <?php
            }
        }
    ?>

    <h2 class="text-h2">Riwayat Penugasan</h2>
    <hr class="hr-custom">
    
    <?php
        foreach($model as $key){
            $submission = $this->context->getProject($key["asg_id"]);
            $old_date = $key["asg_end_time"];
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('l, d M Y, H:i', $old_date_timestamp);
            if($key["sts_asg_id"] == 1){?>
            <ul class="list-group">
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
                <font style="color: #777777;">Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?> </font>
                </li>
            </ul>
    <?php
            }
        }
    ?>
    
</div>