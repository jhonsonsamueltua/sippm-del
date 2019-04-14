<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// echo '<pre>';
// var_dump($model);die();
$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
// $this->css("@web/css/site.css");
$css = ['css/site.css'];
?>
<div class="assignment-index">
    <h3 class="text-muted">Penugasan saat ini</h3>
    <hr style="border-top: 1px solid #d9dada;margin: 5px;">
    
    <?php
        foreach($model as $key){
            $old_date = $key["asg_end_time"];
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('l, d M Y, H:i', $old_date_timestamp);
            if($key["sts_asg_id"] == 1){?>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['style' => 'font-size: medium;']) ?> 
                <div style="float: right;">
                    <?= Html::a('Detail', ['assignment/view', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?> 
                    <?= Html::a('| Edit', ['assignment/update', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?>
                    <?= Html::a('| Hapus', ['assignment/delete', 'id' => $key["asg_id"]], ['style' => 'font-size: ;']) ?> 
                </div>
                <br>
                <font style="color: #777777;">Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?> </font>
                </li>
            </ul>
    <?php
            }
        }
    ?>

    <h3 class="text-muted">Riwayat Penugasan</h3>
    <hr style="border-top: 1px solid #d9dada;margin: 5px;">
    
    <?php
        foreach($model as $key){
            $old_date = $key["asg_end_time"];
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('l, d M Y, H:i', $old_date_timestamp);
            if($key["sts_asg_id"] == 1){?>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]], ['style' => 'font-size: medium;']) ?> 
                <br>
                <font style="color: #777777;">Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?> </font>
                </li>
            </ul>
    <?php
            }
        }
    ?>
    
</div>