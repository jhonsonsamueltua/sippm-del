<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$session = Yii::$app->session;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
   <!--  <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?> -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
            article {
            float: left;
            padding: 0px 10px 10px 0px;
            width: 100%;
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
        
        .navbar-right a {
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
        
        .navbar {
            position: relative;
            min-height: 50px;
            margin-bottom: -10px;
            border: 1px solid transparent;
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
                    <button type="submit"><span class="glyphicon glyphicon-search"></span></button>
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
                        <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-home"></span> Beranda</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><span class="glyphicon glyphicon-about"></span> About</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container">        
            <article>
                <?= Alert::widget() ?>
                <?= $content ?>
            </article>
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