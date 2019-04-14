<?php

  
use yii\helpers\Html;
$this->title = 'SIPPM Del';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="site-proyek">

    <div class="body-content">
        <h2> <?= $model->proj_title ?> </h2>
               
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span>
            <span class="fa fa-star"></span>
            <span class="glyphicon glyphicon-download-alt" align = "right;"></span>                                               
            <hr>
            
        <div class="row">
            <div class = "col-md-3">
                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>File</h4>
                    <?php
                        $session = Yii::$app->session;

                        if(!isset($session['role'])){
                            echo Html::a('Permohonan Penggunaan', ['/site/login', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success']);
                        }else{
                            if($usageModel == null || $usageModel->sts_proj_usg_id == 3){
                                echo Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success']);
                            }else if($usageModel->sts_proj_usg_id == 1){
                                echo Html::a('Ubah Permohonan Penggunaan', ['/project-usage/update', 'proj_id' => $model->proj_id], ['class' => 'btn btn-primary']);
                            }else{
                                echo Html::a("Unduh semua file proyek", ['download-project', 'proj_id' => $model->proj_id]) . "<br>";
                            }
                        }
                    ?>
                </div>

               <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Tanggal</h4>
                    <?php 
                        $date = date_create($model->created_at);
                        echo ("<p>". date_format($date, "d M Y") ."</p>"); 
                    ?>
                </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Dosen Penugas</h4>
                    <?= "<p>". $assignmentModel->created_by ."</p>" ?>
                 </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Diunggah oleh</h4>
                    <?= "<p>". $model->created_by ."</p>" ?>
                </div>
        </div>

        <div class ="col-md-9">
            <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                <h4>Deskripsi</h4>
                <?= $model->proj_description ?>
            </div>
            <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                <h4>Jenis Proyek</h4>
                <p>Proyek Akhir 2</p>
            </div>

            <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                <h4>Tahun Pengerjaan Proyek</h4>
                <p>2016</p>
            </div>

         </div>

    </div>



        
           
     
