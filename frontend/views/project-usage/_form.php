<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */
/* @var $form yii\widgets\ActiveForm */
$css = ['css/site.css'
                ];

?>

<div class="project-usage-form">

<div class="col-md-12 col" align:"center">
<div class="panel panel-primary">
<div class="panel-heading" align="center" style="background-color: #ADD8E6">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="panel-body">

<div class="row">
<div class="container">
    <?php $form = ActiveForm::begin(); ?>
<div class="col-md-10">
    <form class="form-horizontal">


<div class="form-group">    
    <label class="control-label col-xs-3">Id Proyek :</label> 
    <div class="col-xs-9"> 
        <?= $form->field($model, 'proj_id')->textInput() ->label(false) ?>
    </div>
</div> 

<div class="form-group">
    <label class="control-label col-xs-3" for="Nama" >Judul Proyek :</label>
    <div class="col-xs-9">

       <input type="text" class="form-control" name="name" value="'.$item['proj_title'].'" required>
         <br>
    </div>
</div>

 <div class="form-group">    
    <label class="control-label col-xs-3">Tujuan :</label> 
    <div class="col-xs-9">    
        <?= $form->field($model, 'cat_usg_id')->textInput() ->dropDownList([ 'Referensi KP' => 'Referensi KP', 'Kompetisi' => 'Kompetisi', 'Referensi PA' => 'Referensi PA', 'Proyek Mata Kuliah' => 'Proyek Mata Kuliah', 'Lainnya' => 'Lainnya ..',], 
        ['prompt' => 'Tujuan Pengunduhan Proyek ..'])->label(false) ?>
    </div>
</div>

<div class="form-group">   
    <label class="lab control-label col-xs-3">Deskripsi Penggunaan :</label>
    <div class="col-xs-9">
            <!-- <?= $form->field($model, 'proj_usg_usage')->textarea(['rows' => '6'])->label(false)?>  -->
            <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())->label(false)  ?>
    </div> 
</div>

   <!--  <?= $form->field($model, 'sts_proj_usg_id')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?> -->
 
   <!--  <?= $form->field($model, 'deleted_by')->textInput(['maxlength' => true]) ?>
        -->

<div class="form-group">    
    <label class="control-label col-xs-3">Tanggal Request :</label>
    <div class="col-xs-9">
        <?= $form->field($model, 'created_at')->textInput() ->widget(\kartik\datetime\DateTimePicker::className(), ['pluginOptions' => ['format' => 'yyyy-mm-d hh:ii:s', 'pickerPosition' => 'bottom-right']]) ->label(false) ?>
    </div>
</div> 

<!-- <div class="form-group">    
    <label class="control-label col-xs-3">Pembuat Request :</label>
    <div class="col-xs-9">
        <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ->label(false) ?>
    </div>
</div> -->

<!-- <div class="form-group">    
    <label class="control-label col-xs-3">Tanggal Perubahan :</label>      
    <div class="col-xs-9">
        <?= $form->field($model, 'updated_at')->textInput() ->label(false) ?>
    </div>
</div>

<div class="form-group">    
    <label class="control-label col-xs-3">Dirubah Oleh :</label>        
    <div class="col-xs-9">
        <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ->label(false) ?>
    </div>
</div>
 -->
    </div>
    

<div class="col-md-12">
    <div class="form-group" align="center">
        <?= Html::submitButton('Kirim', ['class' => 'btn btn-success']) ?>
    </div>
</div>
</form>
</div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>





