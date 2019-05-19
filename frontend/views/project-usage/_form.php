<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\CategoryUsage;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("././css/project.css");
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


<div class="row">
    <div class="loader"></div>
    <div class="col-md-6">
        <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>
        
            <?= $form->field($model, 'cat_usg_id')->dropDownList(ArrayHelper::map(CategoryUsage::find()->all(), 'cat_usg_id', 'cat_usg_name'), [
                'prompt' => 'Pilih Tujuan Penggunaan...'
            ])->label('Tujuan Penggunaan')?>
            <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())  ?>
        
            <div class="form-btn" align="center">
                <?= Html::submitButton($model->isNewRecord ? 'Kirim' : 'Ubah', ['class' => $model->isNewRecord ? 'btn-md btn-custom' : 'btn-md btn-primary-edit btn-custom', 'style' => 'border: 0px;']) ?>
                &nbsp;&nbsp; <?= Html::a("Batal", ['project-usage/index'], ['class' => 'btn-md btn-custom btn-primary-edit-kembali', 'style' => 'padding: 8px 25px; width: 150px;']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6" style="padding: 15px;border: 1px solid #a79c9c47;border-radius: 5px;">
        <b>Judul Proyek</b>
        <h4 style="margin: 4px 0px 10px 0px;"> <?= $project->proj_title ?> </h4>

        <b style="font-size: 14px">Penulis Proyek</b>
        <p> <?= $project->proj_author ?> </p>

        <b style="font-size: 14px">Koordinator Proyek</b>
        <p> <?= $project->asg->asg_creator ?> </p>

        <!-- <div class="alert alert-info">
            <strong>Info!</strong> <br> Permohonan Penggunaan akan dikirim kepada <i> <?= $project->asg->asg_creator ?>  </i>selaku koordinator proyek.
        </div> -->

    </div>

    <?php
        $this->registerJs("
            var spinner = $('.loader');        

            $('#w0').submit(function(event){
                spinner.show();
            });        

        ", $this::POS_END);
    ?>

</div>