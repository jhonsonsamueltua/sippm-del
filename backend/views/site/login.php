<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="myform">
        <div class="logo">
            <div><i class="fa fa-user" aria-hidden="true"></i></div>
            LOGIN
        </div>
        <?php 
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form'],
                ]);
        ?>
            <?= $form->field($model, 'username', [
                'inputOptions'=>[
                    // 'template' => "\{input}\n{hint}\n{error}",
                    // 'class'=>'form-control',
                    'placeholder'=>"Username"
                ]
            ])->textInput()->label(false); ?>
            <?= $form->field($model, 'password', [
                'inputOptions'=>[
                    // 'template' => "{input}\n{hint}\n{error}",
                    // 'class'=>'form-control',
                    'placeholder'=>"Password"
                ]
            ])->passwordInput()->label(false); ?>
            <!-- <input type="password" placeholder=" &#xf023;  Password" /> -->
            <button type="submit">LOGIN </button>
            <div> <a href="#">Forgot Password?</a> </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

<?php $style= <<< CSS
    p{
        color: #a94442;
    }

    input {
        height: 40px;
        width: 100%;
        margin: 20px auto;
        border-left: none;
        border-right: none;
        border-top: none;
        color: white;
        background: #2A3F54;
  padding-left:5px;
        font-family: FontAwesome, "Open Sans", Verdana, sans-serif;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    }
    
    button {
        height: 40px;
        width: 100%;
        border-radius: 4px;
        margin-top: 30px;
        margin-bottom: 20px;
        border: none;
        background: #1ABB9C;
        color: #ffffff;
        font-family: sans-serif;
        font-weight: 700;
        font-size: 14pt;
    }
    
    .form {
        width: 90%;
        margin: 40px auto;
        text-align: center;
    }
    
    input:focus {
        outline: none
    }
    
    .logo {
        color: white;
        font-family: sans-serif;
        font-size: 15pt;
        font-weight: 600;
        text-align: center;
        padding-top: 40px
    }
    
    .myform {
        background: #2A3F54;
        width: 30%;
        margin: auto;
        height: 600px;
        -webkit-box-shadow: 0px 0px 3px 1px rgba(38, 35, 128, 1);
        -moz-box-shadow: 0px 0px 3px 1px rgba(38, 35, 128, 1);
        box-shadow: 0px 0px 3px 1px rgba(38, 35, 128, 1);
        /* padding : 10px; */
    }
    
    .myform a {
        text-decoration: none;
        color: white;
        font-family: sans-serif;
        letter-spacing: .1em;
    }
    
     ::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
         color: #cccccc;
    }
    input.icon::-webkit-input-placeholder {
        font-family:'FontAwesome';
    }
    .fa-user{
    font-size:90px;
    
    }
    
    ::-moz-placeholder {
        /* Firefox 19+ */
        color: #cccccc;
          }
    
    :-ms-input-placeholder {
        /* IE 10+ */
         color: #cccccc;
         }
    
    :-moz-placeholder {
        /* Firefox 18- */
        color: #cccccc;
      
    }
  @media screen and (max-width:500px){
        .myform{
            width:80%;
        }
    }
    @media screen and (max-width:800px){
        .myform{
            width:80%;
        }
    }

CSS;
$this->registerCss($style);
?>

