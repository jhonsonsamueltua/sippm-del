<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'SIPPM Del';
$css = ['css/site.css'];
?>
<div class="site-index">

    <div class="body-content">
    <br>
        <div>
            <?php
                $title = "";
                if($type == 1){
                    $title = "Sering Digunakan";
                }else if($type == 2){
                    $title = "Kompetisi";
                }else if($type == 3){
                    $title = "Baru Ditambahkan";
                }
            ?>
            <h2 class="text-h2"><?= $title ?></h2>
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
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
            ?>
            
        </div>
    </div>
</div>
<br>

