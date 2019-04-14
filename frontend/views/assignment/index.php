<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penugasan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Tambah Penugasan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'asg_id', 
                'label' => 'ID'],
            ['attribute' => 'asg_title', 
                'label' => 'Penugasan'],
            ['attribute' => 'asg_description', 
                'label' => 'Deskripsi'],
            ['attribute' => 'asg_start_time', 
                'label' => 'Batas Awal'],
            ['attribute' => 'asg_end_time', 
                'label' => 'Batas Akhir'],
            //'asg_year',
            //'class',
            //'course_id',
            //'cat_proj_id',
            //'sts_asg_id',
            //'deleted',
            //'deleted_at',
            //'deleted_by',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]); ?>


</div>
