<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$css = ['css/site.css'
                ];
$this->title = 'Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <body class="login-page"> -->
<div class="site-login">
<div class="col-md-5 col-md-offset-4">
<div class="panel panel-primary">
<div class="login-box-body" align="center" style="background-color: #fff;">
<br>
<p class="login-box-msg" align="center", style="color:black;">
        <img src="images/logo.jpg" width="70px">
        <br>
<br>
        Institut Teknologi Del
        </p>
        <hr>
</div>
<div class="panel-body">
   <!--  <p>Please fill out the following fields to login:</p> -->

    <div class="row">
        <div class="col-lg-12">
        
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ->label('Nama Pengguna')?>

                 
                <?= $form->field($model, 'password')->passwordInput() ->label('Kata Sandi') ?>

              
               <!--  <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:3em 2">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div> -->

                <div class="form-group" align="right">
                    <?= Html::submitButton('Masuk', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    </div>
    </div>

</div>


<!-- </body> -->
<!-- <?php $this->endPage() ?> -->