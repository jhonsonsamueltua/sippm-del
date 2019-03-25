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
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
    
    <?= $form->field($model, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                    ['prompt' => "Pilih Kategori"])->label("Kategori")?>
    
    <?= $form->field($model, 'asg_year')->textInput(['maxlength' => true])->label("Tahun") ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"])->label("Matakuliah") ?>

    <?= $form->field($model, 'asg_title')->textInput(['maxlength' => true])->label("Judul Proyek") ?>
    
    <?php 
        // date_default_timezone_set("Asia/Bangkok");
        $dateNow = date("Y-m-d H:i:s");
    ?>
    <!-- <div class="row">
        <div class="col-xs-12 col-md-6"> -->
            <?= 
                $form->field($model, 'asg_start_time')->widget(DateTimePicker::class,[
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Pilih batas awal ...'],
                    // 'value' => $dateNow,
                    'pluginOptions' => [
                        'autoclose'=>true,
                            'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                    ])->label("Batas awal");
            ?>    
        <!-- </div>
        <div class="col-xs-12 col-md-6"> -->
            <?= 
                $form->field($model, 'asg_end_time')->widget(DateTimePicker::class,[
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Pilih batas awal ...'],
                    // 'value' => $dateNow,
                    'pluginOptions' => [
                        'autoclose'=>true,
                            'format' => 'Y-m-d H:i:s'
                    ]
                    ])->label("Batas akhir");
            ?>
        <!-- </div>
    </div> -->

    <!-- <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ->label("Kelas")?> -->
    <div class="crew-form">
        <div id="field_input"></div>
        <div class="form-group">
            <div class="col-md-3 col-md-offset-3">
                <a href="#" onclick="addMore()">Tambah Kelas >></a>
            </div>
        </div>
    </div>
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
    <?php $this->registerJs("
         var count = 1;
         $(document).ready(function(){
            addMore();
         });

         function addMore(){
            $.ajax({
                url: '".\Yii::$app->urlManager->createUrl(['assignment/class'])."',
                type: 'POST',
                success: function(data){
                    data = jQuery.parseJSON(data);
                    cls = '';
                    for(var i = 0; i < data.length; i++){
                        if(i == 0){
                            cls += '<option selected=\"selected\" value=\"empty\">Pilih kelas...</option>';
                            cls += '<option value=\"'+data[i]['cls_id']+'\">'+data[i]['cls_name']+'</option>';
                        }else{
                            cls += '<option value=\"'+data[i]['cls_id']+'\">'+data[i]['cls_name']+'</option>';
                        }
                    }
                    add(cls);
                }
            });
        }

        function add(cls){
            $('#field_input').append('<div class=\"form-group\"><label class=\"control-label col-sm-3\">Kelas '+count+'</label><div class=\"col-sm-6\"><select id=\"cls_id\" class=\"form-control\" name=\"cls[][cls_id]\">'+cls+'</select><div class=\"help-block help-block-error \"></div></div></div>');
            count++;
        }
    ", $this::POS_END); ?>
</div>
