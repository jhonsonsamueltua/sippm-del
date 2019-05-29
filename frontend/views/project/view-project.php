<?php  
use yii\helpers\Html;
use frontend\controllers\SiteController;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;

$this->title = 'SIPPM Del';
$this->registerCssFile("././css/project.css");
// $this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<?php
    $author = $model->proj_author;
    $author_words = explode(';', $author);
    $author = implode(", ", $author_words);
?>

<?php
    $keyword = $model->proj_keyword;
    $keyword_words = explode(';', $keyword);
    $keyword = implode(",<br>", $keyword_words);
?>

<div class="body-content">
    <div class=" container box-content" >
                <?php
                    echo Breadcrumbs::widget([
                        'itemTemplate' => "<li>{link}</li>\n",
                        'links' => [
                            'Detail Proyek',
                        ],
                    ]);
                ?>
        <br><br>
        <div align="center" style="display: block;">
            <font class="title"><?= $model->proj_title ?></font>
            <font style='color:#9E9E9E'> <?= $author ?> </font>
        </div>

        <hr style="border-top: 2px solid #B2EBF2;">

        <div class="row">
            
            <div class = "col-md-3">
                <div class = "">
                    <font class = "project-sub-content" style="display:block">Artefak Proyek</font>
                    <p>
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
                    </p>
                </div>

                <?php 
                    if($assignmentModel->cat_proj_id == 2){
                        if($model->sts_win_id == 1){
                            echo('
                                <div class = "">
                                    <font class = "project-sub-content">Sertifikat Kemenangan</font><br>
                                    <p>
                            ');

                            Modal::begin([
                                'header' => 'Sertifikat Kemenangan',
                                'toggleButton' => ['label' => 'Lihat Sertifikat', 'class' => 'btn btn-primary'],
                                'size' => 'modal-lg',
                            ]);

                                echo Html::img($model->proj_win_proof, ['class' => 'img-responsive']);

                            Modal::end();

                            echo('  
                                    </p>
                                </div>
                            ');
                        }
                    }   
                ?>

                <div >
                    <font class = "project-sub-content">Kategori Proyek</font><br>
                    <p>
                        <?= $assignmentModel->catProj->cat_proj_name ?> &nbsp;-&nbsp; <?= $assignmentModel->subCatProj->sub_cat_proj_name ?>, <?= $assignmentModel->asg_year ?> 
                    </p>
                </div>
            
                <div class = "">
                    <font class = "project-sub-content">Koordinator Proyek</font><br>
                    <p>
                        <?= $assignmentModel->asg_creator ?>
                    </p>
                </div>

                <div class = "">
                    <font class = "project-sub-content">Kata Kunci</font><br>
                    <p>
                        <?= $keyword ?>
                    </p>
                </div>
                
                <?php 
                    if($assignmentModel->cat_proj_id == 2){
                        echo('
                            <div class = "">
                                <font class = "project-sub-content">Status</font><br>
                                <p>
                                    ' . $model->sts_win_id . '
                                </p>
                            </div>
                        ');
                    }   
                ?>

            </div>

            <div class ="col-md-9">
                <div class = "">
                    <?php 
                        $updated_at = $model["updated_at"];
                        $updated_at_timestamp = strtotime($updated_at);
                        $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);
                    ?>
                    <font style="float: right;font-size: 15px;"><span class="glyphicon glyphicon-eye-open"></span> <?= $model->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $model->proj_downloaded    ?></font> 
                    <font style='color:#9E9E9E'> <?= $updated_at ?>, diunggah oleh <?= $model->proj_creator ?> </font><br><br>
                    <?= $model->proj_description ?>
                </div>       
            </div>

        </div>

    </div>
</div>
        
           
     
