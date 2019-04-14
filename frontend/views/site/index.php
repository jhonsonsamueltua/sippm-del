<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'SIPPM Del';
$css = ['css/site.css'];
?>
<div class="site-index">

    <div class="body-content">
    <br>
        <div>
            <h2 class="text-h2">Apa itu SIPPM Del ?</h2>
            <hr class="hr-custom">
            SIPPM Del (Sistem Informasi Pengolahan Proyek Mahasiswa) is a digital service that collects, preserves, and distributes digital material. Repositories are important tools for preserving an organization's legacy; they facilitate digital preservation and scholarly communication.
        </div>

        <div>
            <h2 class="text-h2">Sering Digunakan</h2>
            <hr class="hr-custom">
            
            <?php
            foreach($model as $data){
                $description = $data->proj_description;
                $limit_words = 30;
                $words = explode(' ',$description);
                $description = implode(" ",array_splice($words,0,$limit_words));

                $author = $data->proj_author;
                $author_words = explode(';', $author);
                $author = implode("; ", $author_words);

                $created_at = $data["created_at"];
                $old_date_timestamp = strtotime($created_at);
                $created_at = date('l, d M Y, H:i', $old_date_timestamp);
                ?>
                <div>
                    <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title']) ?><span class="badge" style="float: right"><span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></span>
                    <div class="text-author">
                        <?= $author ?> (<?= $created_at ?>)
                    </div>

                    <?= $description ?>...
                </div>
            <?php
                }
            ?>
            <?= Html::a("Lihat lainnya...", ['project/view-project']) ?>
        </div>

        <div>
            <h2 class="text-h2">Kompetisi</h2>
            <hr class="hr-custom">
            
            <?php
            foreach($model as $data){
                if($data->asg->cat_proj_id == 2){
                    $description = $data->proj_description;
                    $limit_words = 30;
                    $words = explode(' ',$description);
                    $description = implode(" ",array_splice($words,0,$limit_words));

                    $author = $data->proj_author;
                    $author_words = explode(';', $author);
                    $author = implode("; ", $author_words);

                    $created_at = $data["created_at"];
                    $old_date_timestamp = strtotime($created_at);
                    $created_at = date('l, d M Y, H:i', $old_date_timestamp);
                    ?>
                    <div>
                        <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title']) ?>
                        <span class="badge" style="float: right">
                            <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded  ?>
                        </span>
                        <?php
                            if(isset($data->stsWin->sts_win_name)){
                        ?>
                        <span class="badge" style="float: right">
                            <span class="glyphicon glyphicon-flag"></span>&nbsp; <?= $data->stsWin->sts_win_name  ?>&nbsp;
                        </span>
                        <?php
                            }
                        ?>
                        <div class="text-author">
                            <?= $author ?> (<?= $created_at ?>)
                        </div>

                        <?= $description ?>...
                    </div>
            <?php
                }
            }
            ?>
            <?= Html::a("Lihat lainnya...", ['project/view-project']) ?>
        </div>

        <div>
            <h2 class="text-h2">Baru Ditambahkan</h2>
            <hr class="hr-custom">
            <?php
            foreach($modelNews as $data){
                $description = $data->proj_description;
                $limit_words = 30;
                $words = explode(' ',$description);
                $description = implode(" ",array_splice($words,0,$limit_words));

                $author = $data->proj_author;
                $author_words = explode(';', $author);
                $author = implode("; ", $author_words);

                $created_at = $data["created_at"];
                $old_date_timestamp = strtotime($created_at);
                $created_at = date('l, d M Y, H:i', $old_date_timestamp);
                ?>
                <div>
                    <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title']) ?><span class="badge" style="float: right"><span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></span>
                    <div class="text-author">
                        <?= $author ?> (<?= $created_at ?>)
                    </div>

                    <?= $description ?>...
                </div>
            <?php
                }
            ?>
            <?= Html::a("Lihat lainnya...", ['project/view-project']) ?>
        </div>
    </div>
</div>

