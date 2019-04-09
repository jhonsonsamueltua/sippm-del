<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Proyek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sippm-project-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr style="border-top: 2px solid #d9dada;">
    <?php
        foreach($model as $data){?>
        <?= Html::a($data->proj_title, ['project/view-detail', 'proj_id' => $data->proj_id]) ?>
    <?php
        }
    ?>


</div>
