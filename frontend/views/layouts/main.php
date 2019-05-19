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
use common\models\SippmNotification;
use common\models\Assignment;
use common\models\Project;
use common\models\ProjectUsage;

AppAsset::register($this);
$css = ['css/main.css'];
$js = ['js/main.js'];
$this->registerCssFile("././css/fontAwesome/font-awesome.min.css");

$session = Yii::$app->session;

$query = "SELECT sn.ntf_id FROM sippm_notification sn JOIN sippm_notification_viewer snv ON sn.ntf_id = snv.ntf_id WHERE snv.ntf_reader = '" . $session['username'] ."'";
$listSeenNotifId = Yii::$app->db->createCommand($query)->queryAll();

$modelNotif = SippmNotification::find()->leftJoin('sippm_assignment', 'sippm_notification.asg_id = sippm_assignment.asg_id')
                                       ->leftJoin('sippm_project_usage', 'sippm_notification.proj_usg_id = sippm_project_usage.proj_usg_id')
                                       ->where(['or', 'ntf_recipient="'.$session['username'].'"', 'ntf_recipient="'.$session['kelas_id'].'"'])
                                       ->andWhere(['not in', 'ntf_id', $listSeenNotifId])
                                       ->orderBy('sippm_notification.created_at DESC')
                                       ->all();

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

    <style>
        .notification{
            background-color: transparent; 
            border: 0px; 
            /* margin-top: 16px; */
        }
        .notification .badge{
            position: absolute;
            top: -5px;
            right: -10px;
            padding: 5px 10px;
            border-radius: 50%;
            background: red;
            color: white;
        }

        .notification-box{
            position: absolute;
            
            background: #fff;
        }

        .notification-info{
            line-height: 1.3em;
            font-size: 13px;
        }
        
        .notification-info a{
            color : #03A9F4;
        }

        .notification-info a:hover{
            color :white;
        }

        .notification-info:hover{
            color :white !important;
        }

        .loader{
            display: none;  
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.75) url(images/double-ring.svg) no-repeat center center;
            z-index: 10000;
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
                                    <li><?= Html::a('Daftar Proyek Anda', ['project/list-project']) ?></li>
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
                            <!-- <li><?= Html::a('Tentang', ['site/index'], ['disable' => true]) ?></li> -->
                            <?php
                                if(!isset($session["role"])){?>
                                    <li><?= Html::a('Masuk', ['site/login']) ?></li>
                            <?php
                                }else{?>
                                    <li><?= Html::a('Keluar ('.$session["username"].')', ['site/logout']) ?></li>
                            <?php
                                }
                            ?>
                            <li>
                                <a class="notification fa fa-bell-o fa-lg dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php
                                        $countNotif = 0;
                                        
                                        foreach($modelNotif as $notif){
                                            if($notif->ntf_type == "assignment"){
                                                $assignment = Assignment::find()->where(['asg_id' => $notif->asg_id])->one();
                                                
                                                if($assignment->sts_asg_id == 1){
                                                    $countNotif++;
                                                }
                                            }else if($notif->ntf_type == "request_accepted"){
                                                $countNotif++;
                                            }else if($notif->ntf_type == "request_rejected"){
                                                $countNotif++;
                                            }else if($notif->ntf_type == "new_request"){
                                                $countNotif++;
                                            }else if($notif->ntf_type == "new_request_alternate"){
                                                $countNotif++;
                                            }
                                        }
                                    ?>
                                    <span class="badge" style="margin-top: 6px;margin-right: 10px;padding: 4px 6px;"><?= $countNotif ?></span>
                                </a>
                                <ul class="dropdown-menu" style="min-width: 350px;">
                                    <li class="header" style="border-bottom: 1px solid #ddd;">Notifikasi</li>
                                    <li>
                                        <div style="max-height: 200px; min=width: 300px; overflow: auto;">
                                            <ul style="padding: 5px;">
                                                <?php
                                                    foreach($modelNotif as $notif){
                                                        if($notif->ntf_type == "assignment"){
                                                            $assignment = Assignment::find()->where(['asg_id' => $notif->asg_id])->one();
                                                            
                                                            if($assignment->sts_asg_id == 1){
                                                                echo(" 
                                                                    <li class='notification-info'><a href=". \yii\helpers\Url::to(['/assignment/assignment-student', 'ntf_id' => $notif->ntf_id]) ."><i class='fa fa-circle' style='font-size: 10px;'></i> Penugasan $assignment->asg_title telah dibuka</a></li>
                                                                ");
                                                            }
                                                        }else if($notif->ntf_type == "request_accepted"){
                                                            $request = ProjectUsage::find()->where(['proj_usg_id' => $notif->proj_usg_id])->one();
                                                            $project = Project::find()->where(['proj_id' => $request->proj_id])->one();

                                                            echo(" 
                                                                <li class='notification-info'><a href=". \yii\helpers\Url::to(['/project-usage/view', 'id' => $request->proj_usg_id, 'ntf_id' => $notif->ntf_id]) ."><i class='fa fa-circle' style='font-size: 10px;'></i> Permohonan $project->proj_title telah diterima</a></li>
                                                            ");
                                                        }else if($notif->ntf_type == "request_rejected"){
                                                            $request = ProjectUsage::find()->where(['proj_usg_id' => $notif->proj_usg_id])->one();
                                                            $project = Project::find()->where(['proj_id' => $request->proj_id])->one();

                                                            echo(" 
                                                                <li class='notification-info'><a href=". \yii\helpers\Url::to(['/project-usage/view', 'id' => $request->proj_usg_id, 'ntf_id' => $notif->ntf_id]) ."><i class='fa fa-circle' style='font-size: 10px;'></i> Permohonan $project->proj_title telah ditolak</a></li>
                                                            ");
                                                        }else if($notif->ntf_type == "new_request"){
                                                            $request = ProjectUsage::find()->where(['proj_usg_id' => $notif->proj_usg_id])->one();
                                                            $project = Project::find()->where(['proj_id' => $request->proj_id])->one();

                                                            echo(" 
                                                            <li class='notification-info'><a href=". \yii\helpers\Url::to(['/project-usage', 'ntf_id' => $notif->ntf_id]) ."><i class='fa fa-circle' style='font-size: 10px;'></i> Tanggapi permohonan penggunaan proyek $project->proj_title.</a></li>
                                                            ");
                                                        }else if($notif->ntf_type == "new_request_alternate"){
                                                            $request = ProjectUsage::find()->where(['proj_usg_id' => $notif->proj_usg_id])->one();
                                                            $project = Project::find()->where(['proj_id' => $request->proj_id])->one();

                                                            echo(" 
                                                            <li class='notification-info'><a href=". \yii\helpers\Url::to(['/project-usage', 'ntf_id' => $notif->ntf_id]) ."><i class='fa fa-circle' style='font-size: 10px;'></i> Tanggapi permohonan penggunaan proyek $project->proj_title.</a></li>
                                                            ");
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
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