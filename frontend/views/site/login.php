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
<div class="site-login">  
        <div class="contact-form">
<!-- <div class="col-md-5 col-md-offset-4"> -->
<!-- <div class="panel panel-primary"> -->
    <div class="login-box-body" align="center">
<br>
<p class="login-box-msg" align="center", style="color:black;">
        <img src="images/login.jpg" width="70px" class="avatar">
        <h2>SIPPM IT Del</h2>
        </p>
        <hr>
</div>
<div class="panel-body">
   <!--  <p>Please fill out the following fields to login:</p> -->

    <div class="row">
        <div class="col-lg-12">
            
            <?php 
            $form = ActiveForm::begin(['id' => 'login-form']); 
            $fieldOptions3 = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
            ];
            $fieldOptions4 = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
            ];
                    ?>
           
            
                <?= $form->field($model, 'username', $fieldOptions4)->textInput(['autofocus' => true]) ->label('Nama Pengguna')?>          
        
                <?= $form->field($model, 'password', $fieldOptions3)->passwordInput() ->label('Kata Sandi') ?>
            
              
               <!--  <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:3em 2">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div> -->

                <div class="form-group" align="center">
                    <?= Html::submitButton('Masuk', ['class' => 'btn btn-submit', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    </div>
            </div>
            
        </div>
    </div>
</div>       
            
<!-- <?php $this->endPage() ?> -->