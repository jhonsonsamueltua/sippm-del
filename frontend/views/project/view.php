<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\File;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = $model->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sippm-project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'proj_title',
            'proj_description:html',
            'proj_downloaded',
            [
                'attribute' => 'stsWin.sts_win_name',
                'label' => 'Status menang',
            ],
        ],
    ]) ?>
    <?= Html::a("Unduh semua file proyek", ['download-project', 'proj_id' => $model->proj_id]) . "<br>"; ?>
    <p>File proyek:</p>
    <?php
        $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();
        
        echo("<div class='form-group'>");
        foreach($files as $file){
            echo Html::a($file->file_name, ['download-attachment', 'file_id' => $file->file_id]) . "<br>";
        }
        echo("</div>");
    ?>

    <?php
    /**
     * Tambah kondisi untuk mengecek hanya role tertentu yang dapat mengupdate proyek
     */
    ?>
    <p>
        <?= Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Ubah', ['update', 'id' => $model->proj_id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->proj_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
