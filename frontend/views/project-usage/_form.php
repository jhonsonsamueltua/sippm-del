<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\CategoryUsage;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */
/* @var $form yii\widgets\ActiveForm */

?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


<div class="row">

    <div class="col-md-6">
        <b style="font-size: 14px">Judul</b>
        <h4> <?= $project->proj_title ?> </h4>

        <b style="font-size: 14px">Author</b>
        <p> <?= $project->proj_author ?> </p>

        <b style="font-size: 14px">Koordinator</b>
        <p> <?= $project->asg->asg_creator ?> </p>
        <br>

        <div class="alert alert-info">
            <strong>Info!</strong> <br> Request Penggunaan akan dikirim kepada <i> <?= $project->asg->asg_creator ?>  </i>selaku koordinator proyek.
        </div>

    </div>

    <div class="col-md-6">
        <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>
        
            <?= $form->field($model, 'cat_usg_id')->dropDownList(ArrayHelper::map(CategoryUsage::find()->all(), 'cat_usg_id', 'cat_usg_name'), [
                'prompt' => 'Pilih Tujuan Penggunaan...'
            ])->label('Tujuan Penggunaan')?>
            <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())  ?>
        
            <div class="form-btn" align="center">
                <?= Html::submitButton($model->isNewRecord ? 'Kirim &nbsp;<i style="font-size:16px" class="fa fa-paper-plane" aria-hidden="true"></i>' : 'Edit &nbsp;<i style="font-size:16px" class="far fa-edit"></i>', ['class' => $model->isNewRecord ? 'btn-md btn-custom' : 'btn-md btn-primary btn-custom', 'style' => 'border: 0px;']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
                 

