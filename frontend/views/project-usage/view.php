<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $projectTitle['proj_title'];
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-usage-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        <?= Html::a('Update', ['update', 'id' => $model->proj_usg_id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Cancel', ['delete', 'id' => $model->proj_usg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
