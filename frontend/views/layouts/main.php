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
</head>
<body>
<?php $this->beginBody() ?>

    <div class="min-jumbotron">
        <div class="container text-left">
            <img src="images/logo.jpg" style="height:100px; width:90px;" align="left">
            <b><h1>SISTEM INFORMASI PENGELOLAAN PROYEK MAHASISWA</h1></b>      
        </div>
    </div>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => ' navbar-inverse navbar-fixed-1',
                    ]

            ]);
                $menuItems = [
                    ['label' => 'Beranda', 'url' => ['/site/index']],
                    ['label' => 'Penugasan', 'url' => ['/site/login']],
                    ['label' => 'Request Penggunaan', 'url' => ['/site/contact']],
                ];
            
            // if (Yii::$app->user->isGuest) {
            if(!isset($session["role"])){
                $rMenuItems[] = ['label' => 'Masuk', 'url' => ['/site/login']];
            } else {
                $rMenuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        // 'Logout (' . Yii::$app->user->identity->username . ')',
                        'Logout (' . $session['nama'] . ')',
                        ['class' => 'btn btn-link logout']
                    )
                        . Html::endForm()
                        . '</li>';
            }
            echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-left'],
                    'items' => $menuItems,
                ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $rMenuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <!-- <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?> -->
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div> 

<?php $this->endBody() ?>
</body>
<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <b>Sistem Infomasi Pengelolaan Proyek Mahasiswa </b>
        </p>
        <p class="pull-right"><?= date ('Y') ?></p>
    </div>
</footer>
</html>
<?php $this->endPage() ?>
