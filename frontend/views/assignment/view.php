<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = $model->asg_id;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->asg_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->asg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'asg_id',
                'label' => 'ID Penugasan'],
            ['attribute' => 'asg_title',
                'label' => 'Judul Penugasan'],
            ['attribute' => 'asg_description',
                'label' => 'Deskripsi Penugasan'],
            ['attribute' => 'asg_start_time',
                'label' => 'Batas Awal'],
            ['attribute' => 'asg_end_time',
                'label' => 'Batas Akhir'],
            ['attribute' => 'asg_year',
                'label' => 'Tahun'],
            ['attribute' => 'catProj.cat_proj_name',
                'label' => 'Kategori'],
            ['attribute' => 'course.course_name',
                'label' => 'Matakuliah'],
            ['attribute' => 'stsAsg.sts_asg_name',
                'label' => 'Status'],
            ['attribute' => 'class',
                'label' => 'Kelas']
        ],
    ]) ?>

</div>
