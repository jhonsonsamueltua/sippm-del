<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'SIPPM Del';

?>
<div class="site-index">

    <div class="body-content" style="padding-top: 0px">
        <!-- First Container -->
        <div class="container-fluid bg-1 text-center">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    
                </div>
				<div class="banner-content col-md-8 col-sm-12">
					<h1 class="wow fadeInDown first" data-wow-duration="4s" style="font-weight: 600; font-size: 40px">Cari Ide Terbaik di Kampus <br> Institut Teknologi Del</h1>
					<p class="text-white" style="padding: 10px 0px 0px 0px;">
                        SIPPM Del (Sistem Informasi Pengolahan Proyek Mahasiswa) merupakan sebuah sistem
                        <br> untuk mengumpulkan ide-ide / proyek mahasiswa Institut Teknologi Del.
					</p>
                    <?php $form = ActiveForm::begin([
                        'action' => ['test'],
                        'method' => 'get',
                    ]); ?>
                        <div class="row">
                            <div class="col-lg-12" style="padding: 30px 0px;">
                                <div class="row">
                                    <center>
                                        <div class="col-lg-5 col-md-5 col-sm-12" style="padding:0px;">
                                            <input name="searchWords" type="text" placeholder="Cari proyek ..." class="form-control-custom search-slt">
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-12 p-0" style="padding:0px;">
                                            <select name="searchCategory" placeholder="Category" class="form-control-custom search-slt select-custom">
                                                <option value="" >Pilih Kategori</option>
                                                <option value="">Semua</option>
                                                <option value="Matakuliah">Matakuliah</option>
                                                <option value="Kompetisi">Kompetisi</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-12 " style="padding:0px;">
                                            <button type="submit" class="btn-search" >Search</button>
                                        </div>
                                    </center>   
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end() ?>
                    
					<h4 class="text-white">Pencarian Cepat</h4>

					<div class="courses pt-20 wow fadeIn second" data-wow-duration="10s">
                        <a href="#top-5" class="btn-md button btn-filter" transparent mr-10 mb-10>Top 5 Sering Digunakan</a>
                        <a href="#menang-kompetisi" class="btn-md button btn-filter" transparent mr-10 mb-10>Menang Kompetisi</a>
                        <a href="#baru-ditambahkan" class="btn-md button btn-filter" transparent mr-10 mb-10>Baru Ditambahkan</a>
                        <br>
                        <?= Html::a('Kompetisi', ['project/project-by-category', 'cat' => '1'], ['class' => 'btn-md button btn-filter']) ?>
                        <?= Html::a('Matakuliah', ['project/project-by-category', 'cat' => '2'], ['class' => 'btn-md button btn-filter']) ?>
                        <!-- <?= Html::a('Tugas Akhir', ['site/lihat-lainnya', 'type' => 'tugas_akhir'], ['class' => 'btn-md button btn-filter']) ?> -->
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
                                $created_at = date('Y-m-d', $old_date_timestamp);
                                $created_at = $this->context->tgl_indo($created_at);

                                $title = $data->proj_title;
                                if(strlen($data->proj_title) >= 73 ){
                                    $title = substr($data->proj_title, 0, 73) . '...';
                                }
                                
                                ?>
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
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
                            if($modelCompCount == 0){
                                echo "<i>&nbsp;&nbsp;Tidak ada data.</i>";
                            }else{
                            foreach($modelComp as $data){
                                $description = $data->proj_description;
                                $limit_words = 30;
                                $words = explode(' ',$description);
                                $description = implode(" ",array_splice($words,0,$limit_words));

                                $author = $data->proj_author;
                                $author_words = explode(';', $author);
                                $author = implode("; ", $author_words);

                                $created_at = $data["created_at"];
                                $old_date_timestamp = strtotime($created_at);
                                $created_at = date('Y-m-d', $old_date_timestamp);
                                $created_at = $this->context->tgl_indo($created_at);

                                $title = $data->proj_title;
                                if(strlen($data->proj_title) >= 73 ){
                                    $title = substr($data->proj_title, 0, 73) . '...';
                                }
                                ?>
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project', 'style' => 'color: rgb(255, 255, 255)']) ?><font style="float: right;color:#494c5d"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
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
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?= Html::a('Lihat Lainnya', ['site/lihat-lainnya', 'type' => 'win_comp'], ['class' => 'btn-md button btn-filter', 'style' => 'padding: 8px 30px;']) ?>

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
                                $created_at = date('Y-m-d', $old_date_timestamp);
                                $created_at = $this->context->tgl_indo($created_at);

                                $title = $data->proj_title;
                                if(strlen($data->proj_title) >= 73 ){
                                    $title = substr($data->proj_title, 0, 73) . '...';
                                }
                                ?>
                                <li>
                                    <!-- <div> -->
                                        <?= Html::a($title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->proj_downloaded?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= $data->proj_downloaded    ?></font>
                                        <div class="text-author">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $author ?> (<?= $created_at ?>)
                                        </div>
                                    <!-- </div> -->
                                </li>
                            <?php
                                }
                            if($modelNewsCount == 0){
                                echo "<i>&nbsp;&nbsp;Tidak ada data.</i>";
                            }
                        ?>

                    </ol>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?= Html::a('Lihat Lainnya', ['site/lihat-lainnya', 'type' => 'recently_added'], ['class' => 'btn-md button btn-custom', 'style' => 'padding: 8px 30px;']) ?>

                </div>
            </div>
            
        </div>

    </div>
</div>

