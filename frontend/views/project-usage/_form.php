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
<!-- <div class="request-form"> -->
<div id="reqsub" class="section">
<div class="project-usage-form">
<div class="container">
	<div class="row">
		<div class="reqsub-form">
        <div class="reqsub-bg">
        <div class="form-header">
        <h2>Request Penggunaan Proyek</h2>
            <p>Silahkan melakukan <b>request</b> untuk dapat mengunduh proyek.</p>
            <br>
            <br>
            <!-- <h4>Hal yang wajib diketahui : </h4>
            <p><b>*</b>Proyek yang direquest untuk diunduh akan di teruskan kepada koordinator proyek</p>
            <p><b>*</b>Ketika request dikirim, notifikasi akan masuk kepada koordinator</p>
            <p><b>*</b>Kordinator dapat menolak dan menerima request penggunaan</p>
            <p><b>*</b>Apabila request diterima atau ditolak, notifikasi akan masuk kepada perequest</p>
            <p><b>*</b>Ketika request diterima proyek baru dapat diunduh</p> -->

        </div>
    </div>
    <form>
<?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
 ]); ?>
<div class="row">
<div class="col-md-6">
    <div class="form-group">
    <?= $form->field($model, 'proj_id')->textInput() ?>
    </div> 
</div>  
</div>     
    <?= $form->field($model, 'cat_usg_id')->textInput() ->dropDownList([ 'Referensi KP' => 'Referensi KP', 'Kompetisi' => 'Kompetisi', 'Referensi PA' => 'Referensi PA', 'Proyek Mata Kuliah' => 'Proyek Mata Kuliah', 'Lainnya' => 'Lainnya ..',], 
        ['prompt' => 'Tujuan Pengunduhan Proyek ..'])?>
    
    <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())  ?>
   

   <!--  <?= $form->field($model, 'sts_proj_usg_id')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?> -->
 
   <!--  <?= $form->field($model, 'deleted_by')->textInput(['maxlength' => true]) ?>
        -->
    <?= $form->field($model, 'created_at')->textInput() ->widget(\kartik\datetime\DateTimePicker::className(), ['pluginOptions' => ['format' => 'yyyy-mm-d hh:ii:s', 'pickerPosition' => 'bottom-right']])?>

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
 <div class="form-btn" align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn submit-btn' : 'btn btn-primary']) ?>
    </div>
    </div>
    
</div>
</form>
</div>
</div>
</div>
</div>
</div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>
<!-- </div> -->





