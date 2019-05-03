<?php

use yii\grid\GridView;

?>

<?= GridView::widget([
        'dataProvider' => $searchRes,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'proj_title', 
                'label' => 'ID'],

            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]); ?>