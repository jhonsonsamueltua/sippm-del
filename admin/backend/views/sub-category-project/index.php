<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SubCategoryProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Category Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-category-project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sub Category Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sub_cat_proj_id',
            'sub_cat_proj_name',
            'cat_proj_id',
            'deleted',
            'deleted_at',
            //'deleted_by',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
