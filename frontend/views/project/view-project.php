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
                    <?= Html::a('Sistem Informasi Parna Ulos', ['project/view']) ?>

                </div>

               <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Tanggal</h4>
                    <p>9/9/2016</p>
                </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Dosen Penugas</h4>
                    <p>Mukhammad Solkhin</p>
                 </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Diunggah oleh</h4>
                    <p>Detola Simanjuntak</p>
                </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Kata Kunci</h4>
                    <p>UKM</p>
                    <p>Apul</p>
                    <p>Sistem Informasi</p>
                    <p>Balige</p>
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



        
           
     
