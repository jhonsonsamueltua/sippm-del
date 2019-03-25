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
            'sts_win_id',
        ],
    ]) ?>

    <p>File proyek:</p>
    <?php
        $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();
        
        foreach($files as $file){
            echo "<p>" . $file->file_name . "</p>";
        }
    ?>

    <?php
    /**
     * Tambah kondisi untuk mengecek hanya role tertentu yang dapat mengupdate proyek
     */
    ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->proj_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->proj_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
