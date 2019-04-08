<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectUsageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Usages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-usage-index">
<!-- 
    <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Create Project Usage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'proj_usg_id',
            'proj_usg_usage',
            'proj_id',
            'sts_proj_usg_id',
            'cat_usg_id',
            //'deleted',
            //'deleted_at',
            //'deleted_by',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
