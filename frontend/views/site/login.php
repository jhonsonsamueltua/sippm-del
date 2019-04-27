<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$css = ['css/login.css'];
$this->title = 'Masuk';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="wrapper fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
        <img src="images/logo.jpg" id="icon" alt="Del Logo" />
    </div>
    
    <h2 class="active"> Sign In </h2>

    <?php 
        $form = ActiveForm::begin(['id' => 'login-form']); 
    ?>

    <?= $form->field($model, 'username')->textInput(['id' => 'login', 'class' => 'fadeIn second', 'autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput(['id' => 'password', 'class' => 'fadeIn third', 'placeholder' => 'Password'])->label(false) ?>

    <div class="form-group" align="center">
        <?= Html::submitButton('Sign In', ['class' => 'fadeIn fourth', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</div> 
            
<?php $this->endPage() ?>