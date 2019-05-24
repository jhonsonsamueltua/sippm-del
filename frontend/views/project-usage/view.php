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

$session = Yii::$app->session;

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
        <br>
        <h4><b>Detail Penggunaan Proyek</b></h4>
        <hr class="hr-custom">
        <p>
            <?php
                if($session['username'] == $model->created_by){
                    if($model->sts_proj_usg_id == 1){
                        echo Html::a('Ubah', ['update', 'proj_usg_id' => $model->proj_usg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;']) . "&nbsp;&nbsp;";
                        echo Html::a('Batal', ['cancel', 'proj_usg_id' => $model->proj_usg_id], [
                            'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;',
                            'data' => [
                                'confirm' => 'Apakah anda yakin membatalkan permohonan penggunaan ini?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                }
                echo '&nbsp;&nbsp;';
                if($session['role'] == "Mahasiswa"){
                    echo Html::a('Kembali', ['project-usage/index'], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;background-color:#607d8be3']);
                }else{
                    echo Html::a('Kembali', ['project-usage/index'], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;background-color:#607d8be3']);
                }
            ?>
        
        </p>
        <br>
        <?php
            if($model->sts_proj_usg_id == 3){
                echo DetailView::widget([
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
                            'attribute' => 'proj_usg_reject_message',
                            'label' => 'Alasan Penolakan'
                        ],
                        [
                            'attribute' => '',
                            'label' => 'Artefak Proyek',
                            'value' => function($model){
                                $artefak = "";
                                $session = Yii::$app->session;
                                
                                if($session['username'] == $model->created_by){
                                    if($model->sts_proj_usg_id == 3 || $model->sts_proj_usg_id == 4){
                                        $artefak =  Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                                    }else if($model->sts_proj_usg_id == 1){
                                        $artefak = '---';
                                    }else{
                                        $artefak =  Html::a("Unduh semua file proyek", ['project/download-project', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-info']) . "<br>";    
                                    }
                                }else{
                                    $artefak = '---';
                                }
                                
                                return $artefak;
                            },
                            'format' => 'raw',
                        ],
                        
                    ],
                ]);
            }else{
                echo DetailView::widget([
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
                                $artefak = "";
                                $session = Yii::$app->session;
                                
                                if($session['username'] == $model->created_by){
                                    if($model->sts_proj_usg_id == 3 || $model->sts_proj_usg_id == 4){
                                        $artefak =  Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-success']);
                                    }else if($model->sts_proj_usg_id == 1){
                                        $artefak = '---';
                                    }else{
                                        $artefak =  Html::a("Unduh semua file proyek", ['project/download-project', 'proj_id' => $model->proj->proj_id], ['class' => 'btn btn-info']) . "<br>";    
                                    }
                                }else{
                                    $artefak = '---';
                                }
                                
                                return $artefak;
                            },
                            'format' => 'raw',
                        ],
                        
                    ],
                ]);
            }
        ?>

    </div>
</div>
