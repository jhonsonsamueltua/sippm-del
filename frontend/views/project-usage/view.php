<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use frontend\controllers\SiteController;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $model->proj->proj_title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile("././css/project.css");
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<div class="body-content">
    <div class=" container box-content">

        <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</li>\n",
                'links' => [
                    [
                        'label' => 'Penggunaan Proyek',
                        'url' => ['project-usage/index'],
                    ],
                    'Detail Penggunaan',
                ],
            ]);
        ?>
        <h3><b>Detail Penggunaan Proyek</b></h3>
        <hr class="hr-custom">

        <?= DetailView::widget([
            'model' => $model,
            // 'options' => ['class' => 'border-detail-view'],
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

                        return SiteController::tgl_indo(date('Y-m-d', $date_timestamp)).', '.date('H:i', $date_timestamp);
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
                [
                    'attribute' => '',
                    'label' => 'Artefak Proyek',
                    'value' => function($model){
                        $session = Yii::$app->session;
                        $artefak = "";

                        if(!isset($session['role'])){
                            $artefak = Html::a('Permohonan Penggunaan', ['/site/login', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                        }else{
                            if($model == null || $model->sts_proj_usg_id == 3){
                                // $artefak =  Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                                $artefak = '---';
                            }else if($model->sts_proj_usg_id == 1){
                                // $artefak =  Html::a('Ubah Permohonan Penggunaan', ['/project-usage/update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn btn-primary']);
                                $artefak = '---';
                            }else{
                                if($session['nama'] != $model->proj->asg->asg_creator){
                                    $artefak =  Html::a("Unduh semua file proyek", ['project/download-project', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-info']) . "<br>";
                                }else{
                                    // $artefak =  Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                                    $artefak = '---';
                                }
                            }
                        }
                        
                        return $artefak;
                    },
                    'format' => 'raw',
                ],
                
            ],
        ]) ?>

        
        <p>

            <?php
                $session = Yii::$app->session;

                if(!isset($session['role'])){
                    // $artefak = Html::a('Permohonan Penggunaan', ['/site/login', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                }else{
                    if($model == null || $model->sts_proj_usg_id == 3){
                        // $artefak =  Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                        echo Html::a('Ubah', ['update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']);
                        echo Html::a('Batal', ['delete', 'id' => $model->proj_usg_id], [
                            'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;',
                            'data' => [
                                'confirm' => 'Apakah anda yakin membatalkan permohonan penggunaan ini?',
                                'method' => 'post',
                            ],
                        ]);
                    }else if($model->sts_proj_usg_id == 1){
                        echo Html::a('Ubah', ['update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']);
                        echo Html::a('Batal', ['delete', 'id' => $model->proj_usg_id], [
                            'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;',
                            'data' => [
                                'confirm' => 'Apakah anda yakin membatalkan permohonan penggunaan ini?',
                                'method' => 'post',
                            ],
                        ]);
                    }else{
                        // $artefak =  Html::a("Unduh semua file proyek", ['project/download-project', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-info']) . "<br>";
                    }
                }
            ?>
        
        </p>

    </div>
</div>
