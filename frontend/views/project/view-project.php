<?php  
use yii\helpers\Html;
$this->title = 'SIPPM Del';
$css = ['css/project.css'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    $author = $model->proj_author;
    $author_words = explode(';', $author);
    $author = implode(", ", $author_words);
?>

<div class="site-proyek" >
    <div class="body-content container project-view" style="line-height: 1.4em; padding-top: 20px; padding-bottom: 20px; min-height: 450px;">
        <div align="center">
            <h2 class="text-h2"><?= $model->proj_title ?></h2>
            
            <?= $author ?> <font style="float: right; font-size: 18px;"><span class="glyphicon glyphicon-eye-open"></span> <?= $model->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $model->proj_downloaded    ?></font>                                            
        </div>

        <hr class="hr-custom">
            
        <div class="row">
            <div class = "col-md-4">
                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Artefak Proyek</h4>
                    <?php
                        $session = Yii::$app->session;

                        if(!isset($session['role'])){
                            echo Html::a('Permohonan Penggunaan', ['/site/login', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success']);
                        }else{
                            if($usageModel == null || $usageModel->sts_proj_usg_id == 3){
                                echo Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success']);
                            }else if($usageModel->sts_proj_usg_id == 1){
                                echo Html::a('Ubah Permohonan Penggunaan', ['/project-usage/update', 'proj_usg_id' => $usageModel->proj_usg_id], ['class' => 'btn btn-primary']);
                            }else{
                                echo Html::a("Unduh semua file proyek", ['download-project', 'proj_id' => $model->proj_id]) . "<br>";
                            }
                        }
                    ?>
                </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Dosen Penugas</h4>
                    <?= "<p>". $assignmentModel->asg_creator ."</p>" ?>
                 </div>

                 <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Tanggal Diunggah</h4>
                    <?php 
                        $date = date_create($model->created_at);
                        echo ("<p>". date_format($date, "d M Y") ."</p>"); 
                    ?>
                </div>
                
                 <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                 </div>

                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <h4>Diunggah oleh</h4>
                    <?= "<p>". $model->proj_creator ."</p>" ?>
                </div>
            </div>
        

            <div class ="col-md-8">
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
    </div>
</div>
        
           
     
