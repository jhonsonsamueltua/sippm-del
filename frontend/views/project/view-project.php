<?php  
use yii\helpers\Html;
use frontend\controllers\SiteController;
use yii\widgets\Breadcrumbs;

$this->title = 'SIPPM Del';
$this->registerCssFile("././css/project.css");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    $author = $model->proj_author;
    $author_words = explode(';', $author);
    $author = implode(", ", $author_words);
?>

<div class="body-content">
    <div class=" container box-content" >
        <div class="row">
        <div class="col-md-3"><font style="text-align: center; font-size: 16px;"><span class="glyphicon glyphicon-eye-open"></span> <?= $model->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $model->proj_downloaded    ?></font></div>
        <div class="col-md-6"></div>
        <div class="col-md-3" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        'Detail Proyek',
                    ],
                ]);
            ?>
        </div>
        </div>

        <div align="center">
        <!-- <font style="float: right; font-size: 18px;"><span class="glyphicon glyphicon-eye-open"></span> <?= $model->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $model->proj_downloaded    ?></font>  -->
            <font class="title"><?= $model->proj_title ?></font>
            <font style='color:#9E9E9E'> <?= $author ?> </font>
        </div>

        <hr style="border-top: 2px solid #B2EBF2;">
            
        <div class="row">
            
            <div class ="col-md-9">
                <div class = "simple-item-view-date word-break item-page-field-wrapper table">
                    <?php 
                        $updated_at = $model["updated_at"];
                        $updated_at_timestamp = strtotime($updated_at);
                        $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);
                    ?>
                    <font style='color:#9E9E9E'> <?= $updated_at ?>, diunggah oleh <?= $model->proj_creator ?> </font><br><br>
                    <?= $model->proj_description ?>
                </div>

                
                        <div >
                            <font class = "project-sub-content">Kategori Proyek</font><br>
                            <p><?= $assignmentModel->catProj->cat_proj_name ?> [ <?= $assignmentModel->subCatProj->sub_cat_proj_name ?> ]</p>
                        </div>
                    
                        <div class = "">
                            <font class = "project-sub-content">Dosen Penugas</font><br>
                            <?= "<p>". $assignmentModel->asg_creator ."</p>" ?>
                        </div>
                  
                        <div class = "">
                            <font class = "project-sub-content">Artefak Proyek</font><br>
                            <?php
                                $session = Yii::$app->session;

                                if(!isset($session['role'])){
                                    echo Html::a('Permohonan Penggunaan', ['/site/login', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success', 'style' => 'border-radius: 3px;']);
                                }else{
                                    if($usageModel == null || $usageModel->sts_proj_usg_id == 3){
                                        echo Html::a('Permohonan Penggunaan', ['/project-usage/create', 'proj_id' => $model->proj_id], ['class' => 'btn btn-success', 'style' => 'border-radius: 3px;']);
                                    }else if($usageModel->sts_proj_usg_id == 1){
                                        echo Html::a('Ubah Permohonan Penggunaan', ['/project-usage/update', 'proj_usg_id' => $usageModel->proj_usg_id], ['class' => 'btn btn-primary', 'style' => 'border-radius: 3px;']);
                                    }else{
                                        echo Html::a("Unduh semua file proyek", ['download-project', 'proj_id' => $model->proj_id], ['class' => 'btn btn-info', 'style' => 'border-radius: 3px;']) . "<br>";
                                    }
                                }
                            ?>
                      
                </div>
            </div>
            <div class = "col-md-3">
                <h4>Rekomendasi Lainnya</h4>
                <hr style="border-top: 2px solid #B2EBF2;">
            </div>

        </div>

    </div>
</div>
        
           
     
