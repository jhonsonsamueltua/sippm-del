<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
$css = ['css/site.css'];
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        sidebar {
            float: right;
            width: 20%;
            /* height: 300px;  */
            /* background: #ccc; */
            padding: 35px 0px 0px 0px;
            }

            article {
            float: left;
            /* padding: 0px 10px 10px 0px; */
            width: 80%;
            /* background-color: #f1f1f1; */
            }

            /* Clear floats after the columns */
            section:after {
            content: "";
            display: table;
            clear: both;
            }

            /* Style the footer */
            footer {
            background-color: #777;
            padding: 10px;
            text-align: center;
            color: white;
            }

            /* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
            @media (max-width: 765px) {
                sidebar, article {
                width: 100%;
                height: auto;
            }
        }
        
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 2px solid #d9dada;
        }

        /* search */
        * {
            box-sizing: border-box;
        }
       .example{
           padding: 5px;
           float: right;
       }
       form.example input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid #0f4273;
            float: left;
            width: 85%;
            background: #b2bdc7;
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0px;
            /* color: #ffffff; */
            border-radius: 5px 0px 0px 5px;
            height: 40px;
            /* margin-top: 20px; */
        }

        form.example button {
            float: left;
            width: 15%;
            padding: 10px;
            background: #0f4273;
            color: white;
            font-size: 17px;
            border: 1px solid #173868;
            border-top: none;
            border-left: none;
            cursor: pointer;
            border-radius: 0px 30px 30px 0px;
            height: 40px;
            /* margin-top: 20px; */
        }

        form.example button:hover {
            background: #0f4273;
            border: 1px solid #173868;
            /* border-radius:30px 0px 0px 30px; */
        }
        
        form.example::after {
            content: "";
            clear: both;
            display: table;
        }

        /* navbar */
        .navbar-brand {
            color: white;
        }

        .navbar-toggle .icon-bar {
            display: block;
            width: 22px;
            height: 2px;
            border-radius: 1px;
            background: #0f4273;
        }
        
        .navbar-toggle {
            position: relative;
            float: right;
            padding: 9px 10px;
            margin-right: 15px;
            margin-top: 8px;
            margin-bottom: 8px;
            background-color: #b2bdc7;
            background-image: none;
            border: 1px solid #192552;
            border-radius: 4px;
        }
        
        .navbar-collapse ul li a {
            color: white;
            text-decoration: none;
        }

        .navbar {
            position: relative;
            min-height: 50px;
            margin-bottom: -10px;
            border: 1px solid transparent;
        }

        .navbar-collapse ul li a:hover { 
            color: #b2bdc7;
            background-color: transparent;
        }

        .navbar-collapse .active{
            color: #000;
            /* background: #d65c14; */
        }

        .navbar-collapse .active > a:focus {
            color: #b2bdc7;
            background: transparent;
        }

        @media(min-width: 768px){
            .navbar {
                border-radius: 0px;
            }
        }

        /* panel */
        .panel-primary>.panel-heading {
            color: #fff;
            background-color: #1b6295;
            border-color: #1b6295;
        }
        
        /* footer */
        .site-footer
        {
            background-color:#010520;
            padding:45px 0 20px;
            font-size:15px;
            line-height:24px;
            color:#737373;
        }
        .site-footer hr
        {
            border-top-color:#bbb;
            opacity:0.5
        }
        .site-footer hr.small
        {
            margin:20px 0
        }
        .site-footer h6
        {
            color:#fff;
            font-size:16px;
            text-transform:uppercase;
            margin-top:5px;
            letter-spacing:2px
        }
        .site-footer a
        {
            color:#737373;
        }
        .site-footer a:hover
        {
            color:#3366cc;
            text-decoration:none;
        }
        .footer-links
        {
            padding-left:0;
            list-style:none
        }
        .footer-links li
        {
            display:block
        }
        .footer-links a
        {
            color:#737373
        }
        .footer-links a:active,.footer-links a:focus,.footer-links a:hover
        {
            color:#3366cc;
            text-decoration:none;
        }
        .footer-links.inline li
        {
            display:inline-block
        }
        .site-footer .social-icons
        {
            text-align:right
        }
        .site-footer .social-icons a
        {
            width:40px;
            height:40px;
            line-height:40px;
            margin-left:6px;
            margin-right:0;
            border-radius:100%;
            background-color:#33353d
        }
        .copyright-text
        {
            margin:0
        }
        @media (max-width:991px)
        {
            .site-footer [class^=col-]
            {
                margin-bottom:30px
            }
        }
        @media (max-width:767px)
        {
            .site-footer
            {
                padding-bottom:0
            }
            .site-footer .copyright-text,.site-footer .social-icons
            {
                text-align:center
            }
        }
        .social-icons
        {
            padding-left:0;
            margin-bottom:0;
            list-style:none
        }
        .social-icons li
        {
            display:inline-block;
            margin-bottom:4px
        }
        .social-icons li.title
        {
            margin-right:15px;
            text-transform:uppercase;
            color:#96a2b2;
            font-weight:700;
            font-size:13px
        }
        .social-icons a{
            background-color:#eceeef;
            color:#818a91;
            font-size:16px;
            display:inline-block;
            line-height:44px;
            width:44px;
            height:44px;
            text-align:center;
            margin-right:8px;
            border-radius:100%;
            -webkit-transition:all .2s linear;
            -o-transition:all .2s linear;
            transition:all .2s linear
        }
        .social-icons a:active,.social-icons a:focus,.social-icons a:hover
        {
            color:#fff;
            background-color:#29aafe
        }
        .social-icons.size-sm a
        {
            line-height:34px;
            height:34px;
            width:34px;
            font-size:14px
        }
        .social-icons a.facebook:hover
        {
            background-color:#3b5998
        }
        .social-icons a.twitter:hover
        {
            background-color:#00aced
        }
        .social-icons a.linkedin:hover
        {
            background-color:#007bb6
        }
        .social-icons a.dribbble:hover
        {
            background-color:#ea4c89
        }
        @media (max-width:767px)
        {
            .social-icons li.title
            {
                display:block;
                margin-right:0;
                font-weight:600
            }
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="min-jumbotron" style="background-image: url(https://drncvpyikhjv3.cloudfront.net/sites/131/2016/09/21101909/blue-background-header-1.png);">
            <div class="container text-left">
                <img src="images/logo.png" style="height:auto; width:55px;padding-top:5px" align="left">
                <form class="example" action="/action_page.php" style="margin:auto;max-width:500px">
                    <input type="text" placeholder="Cari di SIPPM Del ..." name="search2">
                    <button type="submit"><span class="glyphicon glyphicon-search"></span></i></button>
                </form>
            </div>
            <nav class="navbar navbar-fixed" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar2">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="icon-bar"></span>                       
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-left" style="margin-left: -25px;">
                            <li class="active"><?= Html::a('<span class="glyphicon glyphicon-home"></span> Beranda', ['site/index']) ?></li>
                            <?php
                                if($session["role"] == "Mahasiswa"){?>
                                    <li class="active"><?= Html::a('Penugasan', ['assignment/assignment-student']) ?></li>
                                    <li class="active"><?= Html::a('List Proyek', ['project/list-project']) ?></li>
                                    <li class="active"><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li>
                            <?php
                                }elseif($session["role"] == "Dosen" || $session["role"] == "Asisten Dosen"){?>
                                    <li class="active"><?= Html::a('Penugasan', ['assignment/assignment-dosen']) ?></li>
                                    <li class="active"><?= Html::a('Request Penggunaan Proyek', ['project-usage/list-project-usage-request']) ?></li>
                                    <li class="active"><?= Html::a('Penggunaan Proyek', ['/project-usage']) ?></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right" style="margin-left: -25px;">
                            <li class="active"><?= Html::a('Tentang', ['site/about']) ?></li>
                            <?php
                                if(!isset($session["role"])){?>
                                    <li class="active"><?= Html::a('<span class="glyphicon glyphicon-user"></span> Masuk', ['site/login']) ?></li>
                            <?php
                                }else{?>
                                    <li class="active"><?= Html::a('<span class="glyphicon glyphicon-user"></span> Keluar ('.$session["nama"].')', ['site/logout']) ?></li>
                            <?php
                                }
                            ?>
                            
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container">
            <section>
            <sidebar>
                    <div class="collapse navbar-collapse" id="myNavbar2">
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Semua Repository</div>
                                <a href="sejarah.html" class="list-group-item">Judul</a>
                                 <a href="fasilitas.html" class="list-group-item">Jenis</a>
                                   <a href="visi.html" class="list-group-item">Dosen Penugas</a>
                                <a href="prestasi.html" class="list-group-item">Tahun Ajaran</a>
                    
                            </div>

                            <!-- <div class="panel panel-primary">
                                <div class="panel-heading">Judul</div>
                                <a href="sejarah.html" class="list-group-item">Aplikasi Toba Bakery</a>
                                 <a href="fasilitas.html" class="list-group-item">Aplikasi Pewarnaan Ulos</a>
                                   <a href="visi.html" class="list-group-item">Sistem 
                                   informasi Apul Ulos</a>
                            </div> -->

                            <div class="panel panel-primary">
                                <div class="panel-heading">Jenis</div>
                                <a href="sejarah.html" class="list-group-item">Kompetisi</a>
                                 <a href="fasilitas.html" class="list-group-item">Proyek Akhir</a>
                                  <a href="fasilitas.html" class="list-group-item">Tugas Akhir</a>
                                  <a href="fasilitas.html" class="list-group-item">PKM</a>
                                  <a href="fasilitas.html" class="list-group-item">Mata Kuliah</a>

                            </div>

                            <!-- <div class="panel panel-primary">
                                <div class="panel-heading">Dosen Penugas</div>
                                <a href="sejarah.html" class="list-group-item">Sejarah</a>
                                 <a href="fasilitas.html" class="list-group-item">Fasilitas</a>
                                   <a href="visi.html" class="list-group-item">Visi Misi</a>
                                <a href="prestasi.html" class="list-group-item">Prestasi</a>
                            </div> -->

                            <div class="panel panel-primary">
                                <div class="panel-heading">Tahun Ajaran</div>
                                <a href="sejarah.html" class="list-group-item">2016</a>
                                 <a href="fasilitas.html" class="list-group-item">2017</a>
                                   <a href="visi.html" class="list-group-item">2018</a>
                                
                            </div>

                           
                        </div>
                    </div>
                </sidebar>
                
                <article>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </article>
            </section>
        </div>
    </div> 

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h6>Cara mendapatkan artefak proyek</h6>
                    <p class="text-justify">Scanfcode.com <i>CODE WANTS TO BE SIMPLE </i> is an initiative  to help the upcoming programmers with the code. Scanfcode focuses on providing the most efficient code or snippets as the code wants to be simple. We will help programmers build up concepts in different programming languages that include C, C++, Java, HTML, CSS, Bootstrap, JavaScript, PHP, Android, SQL and Algorithm.</p>
                </div>
                <div class="col-xs-6 col-md-3">
                    <h6>Bantuan</h6>
                    <ul class="footer-links">
                        <li><a href="http://scanfcode.com/category/c-language/">C</a></li>
                        <li><a href="http://scanfcode.com/category/front-end-development/">UI Design</a></li>
                        <li><a href="http://scanfcode.com/category/back-end-development/">PHP</a></li>
                        <li><a href="http://scanfcode.com/category/java-programming-language/">Java</a></li>
                        <li><a href="http://scanfcode.com/category/android/">Android</a></li>
                        <li><a href="http://scanfcode.com/category/templates/">Templates</a></li>
                    </ul>
                </div>
                <div class="col-xs-6 col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="footer-links">
                    <li><a href="http://scanfcode.com/about/">About Us</a></li>
                    <li><a href="http://scanfcode.com/contact/">Contact Us</a></li>
                    <li><a href="http://scanfcode.com/contribute-at-scanfcode/">Contribute</a></li>
                    <li><a href="http://scanfcode.com/privacy-policy/">Privacy Policy</a></li>
                    <li><a href="http://scanfcode.com/sitemap/">Sitemap</a></li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2019 All Rights Reserved by 
                        <a href="#">PA3-01-ITDEL</a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
