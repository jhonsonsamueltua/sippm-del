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

$css = ['css/site.css'];
$css = ['css/main.css'];
$js = ['js/main.js'];

AppAsset::register($this);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css ">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
  <style>
  body {
    font: 14px 'Montserrat', sans-serif;
    color: #808080;
    font-weight: 400;
    line-height: 2em;
    background-color: white;
  }
  p {font-size: 16px;}
  .margin {margin-bottom: 45px;}
  .bg-1 { 
    background-image: linear-gradient(141deg, #82b2d8 0%, #6AC7C1 51%, #0baabe 75%);
    color: #ffffff;
  }
  .bg-2 { 
    background-color: white;
    /* color: #ffffff; */
  }
  .bg-3 { 
    background-color: #6AC7C1;
    color: #555555;
  }
  .bg-4 { 
    background-color: #2f2f2f; /* Black Gray */
    color: #fff;
  }
  .container-fluid {
    padding: 50px 60px;

  }
  .navbar {
    padding-top: 10px;
    padding-bottom: 10px;
    border: 0;
    border-radius: 0;
    margin-bottom: 0;
    font-size: 15px;
    letter-spacing: 1px;
    font-weight: 400;
    box-shadow: 0px 0px 10px #9E9E9E;
  }
  .navbar-nav  li a:hover {
    color: #6ac7c1 !important;
  }

  /* filter dibawah search */
.button {
    background-color: transparent;
    border: none;
    color: white;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 15px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
  }

  .btn-filter {
    background-color: transparent;
    color: white;
    border: 1px solid #f4f4f4;
  }
  
  .btn-filter:hover {
    background-color: white;
    color: #555;
    text-decoration: none;
  }

  /* dropdown */
    .navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover {
        color: #555;
        background-color: #f8f8f8;
        color: #68c6c3;
    }

    .dropdown-menu>li>a:hover{
        background-color: white;
    }

    .navbar-nav>li>.dropdown-menu {
        padding: 15px 5px;
        background-color: #f8f8f8;
    }

    input[type=text], input[type=password] {
        margin: 0px;
        width: 100%;
        background-color: #ffffff;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #fff;
        border-bottom: 2px solid #7b58ca ;
        }

    /* assignment */
    .nav-tabs>li a {
        color: white;
        cursor: default;
        border-bottom-color: transparent;
    }
    /* .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
        color: #555;
        cursor: default;
        border-bottom-color: transparent;
    } */

    /* content */
    .box-content{
        -moz-box-shadow: 0 0 5px #888;
        -webkit-box-shadow: 0 0 5px#888;
        box-shadow: 0 0 5px #888;
        padding-top: 20px; 
        padding-bottom: 20px;
        min-height: 410px;
    }

    .body-content{
        line-height: 1.4em; 
        padding-top: 20px; 
        padding-bottom: 20px; 
        min-height: 450px;
    }

    /* sidenav */
    .vertical-menu {
    width: 100%;
    }

    .vertical-menu a {
    background-color: #eee;
    color: #555555;
    display: block;
    padding: 12px;
    text-decoration: none;
    letter-spacing: 1px;
    }

    .vertical-menu i {
    font-size: 13px;
    height: 25px;
    padding: 6px;
    color: #9E9E9E;
    background-color: #eee;
    letter-spacing: 1px;
    display: block;
    text-decoration: none;
    }

    .vertical-menu a:hover {
    background-color: #6AC7C1;
    color: #555555;
    }

    .vertical-menu a .b :hover {
    background-color: red;
    color: #555555;
    }

    .vertical-menu a.active, .vertical-menu a.active:focus {
    background-color: #6AC7C1;
    color: #FFF;
    }
    
    /* alert */
    .alert {
        padding: 8px;
        margin : 0px;
        /* background-color: #2196F3;
        color: white; */
    }

    .alert-info{
        border-left: 6px solid #2196F3;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
  </style>
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
            <a class="navbar-brand" href="#">SIPPM Del</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                            <li ><?= Html::a('Beranda', ['site/index']) ?></li>
                            <?php
                                if($session["role"] == "Mahasiswa"){?>
                                    <!-- <li><?= Html::a('Penugasan', ['assignment/assignment-student']) ?></li>
                                    <li><?= Html::a('List Proyek', ['project/list-project']) ?></li>
                                    <li><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li> -->
                                    <!-- <li><?= Html::a('Managemen Proyek', ['/project-usage']) ?></li> -->

                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">
                                            Managemen Proyek
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
                                        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer">Managemen Proyek
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
                            <li><?= Html::a('Tentang', ['site/about']) ?></li>
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
