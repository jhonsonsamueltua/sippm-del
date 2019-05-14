<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\CategoryProject;
AppAsset::register($this);
$css = ['css/main.css'];
$js = ['js/main.js'];
$session = Yii::$app->session;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->head() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

</head>
<body>
<?php $this->beginBody() ?>
    <!-- Navbar -->
    <nav class="navbar navbar-default" style="background-color: #eeeeee;">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <?= Html::a('Sippm Del', ['site/index'], ['class' => 'navbar-brand']) ?>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><?= Html::a('Beranda', ['site/index']) ?></li>
                    <?php
                        if($session["role"] == "Mahasiswa"){?>
                            <!-- <li><?= Html::a('Penugasan', ['assignment/assignment-student']) ?></li>
                            <li><?= Html::a('List Proyek', ['project/list-project']) ?></li>
                            <li><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li> -->
                            <!-- <li><?= Html::a('Managemen Proyek', ['/project-usage']) ?></li> -->

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">
                                    Manajemen Proyek
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><?= Html::a('Penugasan', ['assignment/assignment-student']) ?></li>
                                    <li> <hr style="padding: 0px; margin: 5px;"> </li>                                            
                                    <li><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li>
                                    <li> <hr style="padding: 0px; margin: 5px;"> </li>              
                                    <li><?= Html::a('List Proyek', ['project/list-project']) ?></li>
                                </ul>
                            </li>
                    <?php
                        }elseif($session["role"] == "Dosen" || $session["role"] == "Asisten Dosen"){?>
                                    <!-- <li><?= Html::a('Request Penggunaan Proyek', ['project-usage/list-project-usage-request']) ?></li> -->
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">Manajemen Proyek
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><?= Html::a('Penugasan', ['assignment/assignment-dosen']) ?></li>
                                            <li> <hr style="padding: 0px; margin: 5px;"> </li>                                            
                                            <li><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li>
                                        </ul>
                                    </li>
                                    
                            <?php
                                }
                            ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">
                                    Kategori
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">

                                    <?php
                                        $category = CategoryProject::find()->where("deleted != 1")->orderBy("cat_proj_name ASC")->all();
                                        $i = 0;
                                        foreach($category as $cat){?>
                                            <li> <?= Html::a($cat->cat_proj_name, ['project/project-by-category', 'cat' => $cat->cat_proj_id]) ?> </li>
                                            
                                    <?php
                                        if($i <= (count($category) - 2)){
                                                echo '<li> <hr style="padding: 0px; margin: 5px;"> </li>';
                                            }
                                            $i++;
                                        }
                                    ?>
                                    
                                </ul>
                            </li>
                            <li><?= Html::a('Tentang', ['site/index'], ['disable' => true]) ?></li>
                            <?php
                                if(!isset($session["role"])){?>
                                    <li><?= Html::a('Masuk', ['site/login']) ?></li>
                            <?php
                                }else{?>
                                    <li><?= Html::a('Keluar ('.$session["username"].')', ['site/logout']) ?></li>
                            <?php
                                }
                            ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- <div class="container"> -->
        <?= Alert::widget() ?>
        <?= $content ?>
    <!-- </div> -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <center >
                        <p class="copyright-text">Copyright &copy; 2019 All Rights Reserved by 
                            <a href="#">PA3-01-ITDEL</a>.
                        </p>
                        <!-- <hr> -->
                    </center>
                </div>
            </div>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>