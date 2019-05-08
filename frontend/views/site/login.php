<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Masuk';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
        <img src="images/logo.jpg" id="icon" alt="Del Logo" />
    </div>
    <h3 class="active"> Log In SIPPM Del</h3>
    <br><br>
    <?php 
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form'],
            ]);

        $border_bottom = "";
        if($error == true){
            $border_bottom = " 2px solid #FF5722";
        }
    ?>

    <?= $form->field($model, 'username')->textInput(['id' => 'login', 'class' => 'fadeIn second', 'style' => 'border-bottom: '.$border_bottom.'', 'autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput(['id' => 'password', 'class' => 'fadeIn third', 'style' => 'border-bottom: '.$border_bottom.'', 'placeholder' => 'Password'])->label(false) ?>
        <span class="glyphicon glyphicon-eye-open"></span>
    </div>
    <!-- <?= $form->field($model, 'password')->passwordInput(['id' => 'password', 'class' => 'fadeIn third', 'style' => 'border-bottom: '.$border_bottom.'', 'placeholder' => 'Password'])->label(false) ?> -->
    <?php
        if($error == true){
            echo "<font class='text-error'> <i class='fa fa-warning' style='font-size:16px;color:red'></i> &nbsp;Maaf, username atau password anda salah. </font>";
        }
    ?>
    <div class="form-group" align="center">
        <button type="submit" class="fadeIn fourth">Log In </button>
        <!-- <?= Html::submitButton('Log In', ['class' => 'fadeIn fourth', 'name' => 'login-button']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</div> 

            
<?php $this->endPage() ?>

<?php
     $this->registerJs('
     $(".glyphicon-eye-open").on("click", function() {
        $(this).toggleClass("glyphicon-eye-close");
          var type = $("#password").attr("type");
        if (type == "text"){ 
          $("#password").prop("type","password");}
        else{ 
          $("#password").prop("type","text"); }
        });
     ', $this::POS_END);
?>