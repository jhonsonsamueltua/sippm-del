<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\CategoryProject;
use common\models\Course;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assignment-form">
<h1><?= Html::encode($this->title) ?></h1>
    <!-- <?php $form = ActiveForm::begin(); ?> -->
    <?php $form = ActiveForm::begin(['options' => [
        'enctype' => 'multipart/form-data',],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}\n{hint}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
    
    <?= $form->field($model, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                    ['prompt' => "Pilih Kategori"])->label("Kategori")?>
    
    <?= $form->field($model, 'asg_year')->textInput(['maxlength' => true])->label("Tahun") ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"]) ?>

    <?= $form->field($model, 'asg_title')->textInput(['maxlength' => true])->label("Judul Proyek") ?>

    <?php 
        $dateNow = date("Y-m-d H:i:s");
        echo '<label class="control-label">Event Time</label>';
        echo DateTimePicker::widget([
            'name' => 'dp_3',
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
            'value' => $dateNow,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd HH:ii:ss'
            ]
        ]);
    ?>

    <?= $form->field($model, 'asg_start_time')->textInput()->label("Batas Awal") ?>

    <?= $form->field($model, 'asg_end_time')->textInput()->label("Batas Akhir") ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ->label("Kelas")?>

    <?= $form->field($model, 'asg_description')->textarea(['rows' => 6])->hint('Max 500 characters.')->label("Deskripsi")?>

    <!-- <?= $form->field($model, 'sts_asg_id')->textInput() ?> -->

    <!-- <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <?= $form->field($model, 'deleted_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
