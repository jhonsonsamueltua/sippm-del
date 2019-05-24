<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Masuk';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>

    .loader{
        display: none;  
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.75) url(../../../images/double-ring.svg) no-repeat center center;
        z-index: 10000;
    }

</style>
<div class="wrapper fadeInDown">
<div class="loader"></div>
  <div id="formContent">
    <div class="fadeIn first">
        <img src="../../../images/logo.jpg" id="icon" alt="Del Logo" />
    </div>
    <h3 class="active"> SIPPM Del</h3>
    <br><br>
    <?php 
    // $error = "";
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form'],
            ]);

        $border_bottom_username = " ";
        $border_bottom_password = "";
        $autofocus_username = true;
        $autofocus_password = false;
        if($error == "data" || $error == "username_password"){
            $border_bottom_username = " 2px solid #FF5722";
            $border_bottom_password = " 2px solid #FF5722";
        }elseif($error == "username"){
            $border_bottom_username = " 2px solid #FF5722";
        }elseif($error == "password"){
            $border_bottom_password = " 2px solid #FF5722";
            $autofocus_username = false;
            $autofocus_password = true;
        }
    ?>
    <div class="form-group">
        <?= $form->field($model, 'username', ['enableClientValidation' => true])->textInput(['id' => 'login', 'class' => 'fadeIn second', 'style' => 'border-bottom: '.$border_bottom_username.'', 'autofocus' => $autofocus_username, 'placeholder' => 'Nama Pengguna'])->label(false) ?>
        <?php 
            if($error == "username_password" || $error == "username"){
                echo "<font class='text-error'> &nbsp;Nama Pengguna tidak boleh kosong. </font>";
            }
        ?>
    </div>
    
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput(['id' => 'password', 'class' => 'fadeIn third', 'style' => 'border-bottom: '.$border_bottom_password.'', 'autofocus' => $autofocus_password, 'placeholder' => 'Kata Sandi'])->label(false) ?>
        <span class="glyphicon glyphicon-eye-open"></span>
        
        <?php
            if($error == "username_password" || $error == "password"){
                echo "<font class='text-error'> &nbsp;Kata Sandi tidak boleh kosong. <br></font>";
            }
        ?>
    </div>
    
    <?php
        // if($error == "data"){
        //     echo "<font class='text-error'> <i class='fa fa-warning' style='font-size:16px;color:red'></i> &nbsp;Nama Pengguna atau Kata Sandi anda salah. <br><br></font>";
        // }
    ?>
    <div class="form-group" align="center">
    <br>
        <button type="submit" class="fadeIn fourth">Masuk </button>
        <!-- <?= Html::submitButton('Masuk', ['class' => 'fadeIn fourth', 'name' => 'login-button']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

  </div>
</div> 

            
<?php $this->endPage() ?>

<?php
     $this->registerJs('

     var spinner = $(".loader");
     
     $("#login-form").submit(function(){
         spinner.show();
     });

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