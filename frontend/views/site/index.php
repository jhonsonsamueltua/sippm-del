<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'SIPPM Del';
$css = ['css/main.css'];
?>
<div class="site-index">

    <div class="body-content" style="padding-top: 0px">
        <!-- First Container -->
        <div class="container-fluid bg-1 text-center">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    
                </div>
				<div class="banner-content col-md-8 col-sm-12">
					<h1 class="wow fadeIn" data-wow-duration="4s" style="font-weight: 600; font-size: 40px">We Rank the Best Courses <br> on the Web</h1>
					<p class="text-white">
                        In the history of modern astronomy, there is probably no one greater leap forward 
                        <br> than the building and launch of the space
						telescope.
					</p>
                    <?php $form = ActiveForm::begin([
                        'action' => ['search-res'],
                        'method' => 'get',
                    ]); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <center>
                                        <div class="col-lg-5 col-md-5 col-sm-12 " style="padding:0px;">
                                            <?= $form->field($searchModel, 'globalSearch')->textInput(['class' => 'form-control-custom search-slt', 'placeholder' => 'Enter Keywords'])->label(false) ?>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 p-0" style="padding:0px;">
                                            <?= $form->field($searchModel, 'globalSearchCategory')->dropDownList(['all' => 'All', 'matakuliah' => 'Matakuliah', 'kompetisi' => 'Kompetisi'], [
                                                "prompt" => "Pilih Status",
                                                'class' => 'form-control-custom search-slt',
                                                'id' => 'exampleFormControlSelect1',
                                            ])->label(false) ?>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 " style="padding:0px;">
                                            <?= Html::submitButton('Search', ['class' => 'btn wrn-btn', 'style' => 'border-radius: 0px; background: linear-gradient(90deg, #28bce4 0%, #7e54c9 100%); font-size: 18px;']) ?>
                                        </div>
                                    </center>   
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end() ?>
                    
					<h4 class="text-white">Filter Pencarian</h4>

					<div class="courses pt-20">
                        <a href="#top-5" class="btn-md button btn-filter" transparent mr-10 mb-10>Top 5 Sering Digunakan</a>
                        <a href="#menang-kompetisi" class="btn-md button btn-filter" transparent mr-10 mb-10>Menang Kompetisi</a>
                        <a href="#baru-ditambahkan" class="btn-md button btn-filter" transparent mr-10 mb-10>Baru Ditambahkan</a>
                        <br>
                        <a href="#" class="btn-md button btn-filter" transparent mr-10 mb-10>Kompetisi</a>
                        <a href="#" class="btn-md button btn-filter" transparent mr-10 mb-10>Matakuliah</a>
                        <a href="#" class="btn-md button btn-filter" transparent mr-10 mb-10>Tugas Akhir</a>
					</div>
                </div>
                <div class="col-md-2 col-sm-12">
                    
                </div>
            </div>
        </div>

        <!-- Second Container -->
        <div class="container-fluid bg-2" id="top-5">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <img src="images/top.png" align="center" class="hero-image" width="400px" height="auto" style=" margin-left: -80px;">
                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                <h2 class="text-title" >Top 5 Sering Digunakan</h2>
                <hr class="hr-custom">
                    <ol class="custom-counter">
                    
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
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
                                        <div class="text-author">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $author ?> (<?= $created_at ?>)
                                        </div>
                                    <!-- </div> -->
                                </li>
                            <?php
                                }
                            if($modelCount == 0){
                                echo "<i>&nbsp;&nbsp;Tidak ada data.</i>";
                            }
                        ?>

                    </ol>

                </div>
            </div>
            
        </div>

        <!-- Third Container -->
        <div class="container-fluid bg-3" id="menang-kompetisi">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <h2 class="text-title" style="color: #FFF">Menang Kompetisi</h2>
                    <hr class="hr-custom-2">
                    <ol class="custom-counter">
                    
                        <?php
                            if($model == 0){
                                echo "<i>&nbsp;&nbsp;Tidak ada data.</i>";
                            }else{
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
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project', 'style' => 'color: rgb(255, 255, 255)']) ?><font style="float: right;color:#494c5d"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
                                        <div class="text-author" style="color: #e9eaea;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $author ?> (<?= $created_at ?>)
                                        </div>
                                    <!-- </div> -->
                                </li>
                            <?php
                                }
                            }
                        ?>

                    </ol>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#top-5" class="btn-md button btn-filter" style="padding: 8px 30px;" transparent mr-10 mb-10>Lihat Lainnya</a>

                </div>
                <div class="col-md-3 col-sm-12">
                    <img src="images/winner.png" align="center" width="300px" height="auto" class="hero-image" style="margin-left: ;">
                </div>

            </div>
            
        </div>

        <!-- Second Container -->
        <div class="container-fluid bg-2" id="baru-ditambahkan">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <img src="images/news.png" align="center" class="hero-image">
                </div>
                <div class="col-md-9 col-sm-12">
                <h2 class="text-title" >Baru Ditambahkan</h2>
                <hr class="hr-custom">
                    <ol class="custom-counter">
                    
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
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
                                        <div class="text-author">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $author ?> (<?= $created_at ?>)
                                        </div>
                                    <!-- </div> -->
                                </li>
                            <?php
                                }
                            if($modelCount == 0){
                                echo "<i>&nbsp;&nbsp;Tidak ada data.</i>";
                            }
                        ?>

                    </ol>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button href="#top-5" class="btn-md button btn-custom" style="padding: 8px 30px;" transparent mr-10 mb-10>Lihat Lainnya</button>

                </div>
            </div>
            
        </div>

    </div>
</div>

