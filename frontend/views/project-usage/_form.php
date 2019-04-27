<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\CategoryUsage;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */
/* @var $form yii\widgets\ActiveForm */
$css = ['css/site.css'];
?>
<br>
<div id="reqsub" class="section">
    <div class="project-usage-form">
        <div class="container">
            <div class="row">
                <div class="reqsub-form">
                    <div class="reqsub-bg">
                        <div class="form-header">
                            <?php
                            if($model->isNewRecord){
                                echo('
                                    <h2>Request Penggunaan Proyek</h2>
                                    <p>Silahkan melakukan <b>request</b> untuk dapat mengunduh proyek.</p>
                                ');
                            }else{
                                echo('
                                    <h2>Ubah Request Penggunaan Proyek</h2>
                                    <p>Silahkan mengubah <b>request</b> penggunaan proyek.</p>
                                ');
                            }
                            ?>
                            <br><br>
                        </div>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>
                    
                        <?= $form->field($model, 'cat_usg_id')->dropDownList(ArrayHelper::map(CategoryUsage::find()->all(), 'cat_usg_id', 'cat_usg_name'), [
                            'prompt' => 'Tujuan Pengunduhan Proyek ..'
                        ])?>
                        
                        <?= $form->field($model, 'proj_usg_usage')->widget(Redactor::className())  ?>
                    
                        <div class="form-btn" align="center">
                            <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Ubah', ['class' => $model->isNewRecord ? 'btn submit-btn' : 'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

