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
?>
<div class="assignment-index">


    <h2>Penugasan saat ini</h2>
    <hr style="border-top: 2px solid #d9dada;">

    <?php
        foreach($model as $key){
            $old_date = $key["asg_end_time"];
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('l, d M Y, H:i', $old_date_timestamp);
            if($key["sts_asg_id"] == 1){?>
        <?= Html::a($key["asg_title"], ['project/create', 'asg_id' => $key["asg_id"]]) ?>
        <br>Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?>
    <?php
            }
        }
    ?>

    <h2>Riwayat penugasan</h2>
    <hr style="border-top: 1px solid #d9dada;">

    <?php
        foreach($model as $key){
            $old_date = $key["asg_end_time"];
            $old_date_timestamp = strtotime($old_date);
            $new_date = date('l, d M Y, H:i', $old_date_timestamp);
            if($key["sts_asg_id"] == 2){?>
        <?= Html::a($key["asg_title"], ['assignment/view-detail-assignment', 'asg_id' => $key["asg_id"]]) ?>
        <br>Batas Akhir : <?= $new_date?>, Oleh : <?= $key["created_by"]?>
    <?php
            }
        }
    ?>
    
</div>
