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
<div class="row">

    <div class="col-md-6">
        <b style="font-size: 16px">Judul</b>
        <h4><b> "<?= $project->proj_title ?>" </b></h4>

        <b style="font-size: 16px">Author</b>
        <p> <?= $project->proj_author ?> </p>

        <b style="font-size: 16px">Koordinator</b>
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
                'prompt' => 'Pilih Kategori Penggunaan..'
            ])->label('Tujuan Penggunaan')?>
            <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())  ?>
        
            <div class="form-btn" align="center">
                <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn submit-btn' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
                 

