<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $model->proj->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$css = ['css/site.css'];
?>
<div class="body-content">
    <div class=" container box-content">

        <div style="float:right; margin-top: 10px;">
        <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        [
                            'label' => 'Penggunaan Proyek',
                            'url' => ['project-usage/index'],
                        ],
                        'Detail Penggunaan',
                    ],
                ]);
            ?>
        </div>

        <h3><b>Detail Penggunaan Proyek</b></h3>
        <hr class="hr-custom">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'proj_id',
                    'label' => 'Judul Proyek',
                    'format' => 'raw',
                    'value' => function($model){
                            return Html::a($model->proj->proj_title, ['/project/view-project', 'proj_id' => $model->proj->proj_id], ['class' => 'text-title-project']);
                    },
                ],
                [
                    'attribute' => 'proj_usg_creator',
                    'label' => 'Direquest oleh'
                ],
                [
                    'attribute' => 'updated_at',
                    'label' => 'Tanggal request',
                    'value' => function($model){
                        $date = $model["updated_at"];
                        $date_timestamp = strtotime($date);

                        return date('l, d M Y, H:i', $date_timestamp);
                    },
                ],
                [
                    'attribute' => 'proj.asg.asg_creator',
                    'label' => 'Koordinator Proyek'
                ],
                [
                    'attribute' => 'catUsg.cat_usg_name',
                    'label' => 'Kategori Penggunaan'
                ],
                [
                    'attribute' => 'proj_usg_usage',
                    'label' => 'Keterangan Penggunaan',
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'stsProjUsg.sts_proj_usg_name',
                    'label' => 'Status permohonan'
                ],
                
            ],
        ]) ?>

        <!-- <p>
            <?= Html::a('Update', ['update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Cancel', ['delete', 'id' => $model->proj_usg_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p> -->

    </div>
</div>
