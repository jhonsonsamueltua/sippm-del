<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $model->proj->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$css = ['css/site.css'];
?>
<div class="project-usage-view">
<br>
    <h2 class="text-h2">Detail Penggunaan Proyek <b> <?= Html::encode($this->title) ?> </b> </h2>
    <hr class="hr-custom">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'proj_id',
                'label' => 'Judul Proyek',
                'format' => 'raw',
                'value' => function($model){
                        return Html::a($model->proj->proj_title, ['project/view-project', 'proj_id' => $model->proj->proj_id]);
                },
            ],
            [
                'attribute' => 'catUsg.cat_usg_name',
                'label' => 'Kategori Penggunaan'
            ],
            'proj_usg_usage:html',
            [
                'attribute' => 'stsProjUsg.sts_proj_usg_name',
                'label' => 'Status permohonan'
            ],
            
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Cancel', ['delete', 'id' => $model->proj_usg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
