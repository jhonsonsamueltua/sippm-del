<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\CategoryProject;
use common\models\SubCategoryProject;
use common\models\StudentAssignment;
use yii\redactor\widgets\Redactor;
use kartik\datetime\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\Breadcrumbs;

$this->registerCssFile("././css/assignment-form.css");
$session = Yii::$app->session;
?>

<style>

    .class-error {
        font-size: 14px;
        color: #A94442;
    }

    .error-border {
        border-color: #A94442;
    }

    .label-error.active{
        color: #A94442;
    }

</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<div class="row">
        
    <?php $form = ActiveForm::begin(['options' => [
        'enctype' => 'multipart/form-data',],
        'id' => 'dynamic-form',
        'enableClientValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}\n{hint}",
        ],
    ]); ?>

        <div class="col-md-12">

            <?php
                $year = array();
                $year_now = (int)date('Y');
                for($i = $year_now; $i >= 2016; $i--){
                    $year[$i] = $i;
                }
            ?>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($modelAsg, 'asg_year')->dropDownList($year)->label('Tahun Proyek') ?>  
                </div>
            </div>

            <?= $form->field($modelAsg, 'asg_title')->textArea(['maxlength' => true])->label() ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($modelAsg, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                        ['prompt' => "Pilih Kategori...", 
                        'onchange' => '
                            $.get("index.php?r=assignment/lists&id='.'"+$(this).val(), function( data ) {
                                $("select#sub_cat_proj_id" ).html( data );
                            });
                            '
                        ])->label()?>
                </div>
                <div class="col-md-6">
                <?php
                        if(!$modelAsg->isNewRecord){
                            echo $form->field($modelAsg, 'sub_cat_proj_id')->dropDownList(ArrayHelper::map(SubCategoryProject::find()->where(['cat_proj_id' => $modelAsg->cat_proj_id])->all(), 'sub_cat_proj_id', 'sub_cat_proj_name'), ["prompt" => "Pilih Sub Kategori...", 'id' => 'sub_cat_proj_id'])->label();
                        }else{
                            echo $form->field($modelAsg, 'sub_cat_proj_id')->dropDownList(ArrayHelper::map(SubCategoryProject::find()->where('0')->all(), 'sub_cat_proj_id', 'sub_cat_proj_name'), ["prompt" => "Pilih Sub Kategori...", 'id' => 'sub_cat_proj_id'])->label();
                        }
                    ?>
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($modelAsg, 'asg_start_time', ['enableClientValidation' => !$modelAsg->isNewRecord ? false : true])->widget(DateTimePicker::class, [
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'pickerIcon' => '<i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 19px;color: #64B5F6"></i>',
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Pilih batas awal ...'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd hh:ii:ss'
                        ],
                        'class' => 'form-control'
                    ])->label(); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($modelAsg, 'asg_end_time')->widget(DateTimePicker::class, [
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'pickerIcon' => '<i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 19px;color: #64B5F6"></i>',
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Pilih batas akhir ...'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd hh:ii:ss'
                        ]
                    ])->label(); ?>
                </div>
            </div>
            
            <?= $form->field($modelAsg, 'asg_description')->widget(Redactor::classname(), [
                'options' => [
                    'minHeight' => 500,
                    // 'required' => true,
                ],
            ]) ?>

            <br>
            <h4><b>Penerima Penugasan</b></h4>
            <!-- <hr class="hr-custom"> -->
            <?php
                if(!$modelAsg->isNewRecord){

                    if($modelAsg->class == "All"){
                        echo "<p><b>Kelas yang ditugaskan</b>: semua kelas ditugaskan</p>";
                    }else{
                        echo("<p>Kelas yang ditugaskan:</p> 
                            <div class='col-md-6' style='overflow: scroll; max-height: 250px;'>
                                <ul>");
                                $i = 1;

                                foreach($modelClass as $key => $cls){
                                    
                                    if(!$cls->partial){
                                        $data_class = $this->context->getClassByClassId($cls->class);
                                        $class = '';
                                        if($i == 1){
                                            $class = '<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">&nbsp;'.''."".$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                        }else{
                                            $class = $class.''.'<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.''.''.$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                        }

                                        echo '<div class="row">
                                                <div class="col-md-1 col-sm-6 col-xs-6">'
                                                    .Html::a('<span class="glyphicon glyphicon-minus">', ['remove-class', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $cls->cls_asg_id], ['class' => 'btn btn-danger-custom btn-xs']).
                                                '</div>
                                                <div class="col-md-11 col-sm-6 col-xs-6" style="padding: 4px 20px;">'
                                                .$class.
                                                '</div>
                                            </div>';
                                        $i++;
                                    }
                                }
                            echo '</ul>';
                        echo '</div>';
                    }
                } 
            ?>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class='label-error' style="font-weight: 700;">
                                    <div class="col-md-10">Kelas</div>
                                    <div class="col-md-2" style="padding: 0px">
                                        <?php
                                            if($modelAsg->class == "All"){
                                                echo('
                                                    <button type="button" class="btn btn-success-custom btn-xs" onclick="addMoreClass()" disabled="true"><span class="glyphicon glyphicon-plus"></span></button>
                                                    <button type="button" class="btn btn-danger-custom btn-xs" onclick="removeClass()" disabled="true"><span class="glyphicon glyphicon-minus"></span></button>
                                                ');
                                            }else{
                                                echo('
                                                    <button type="button" class="btn btn-success-custom btn-xs" onclick="addMoreClass()"><span class="glyphicon glyphicon-plus"></span></button>
                                                    <button type="button" class="btn btn-danger-custom btn-xs" onclick="removeClass()"><span class="glyphicon glyphicon-minus"></span></button>
                                                ');
                                            }
                                            

                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="list-class">
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2">
                    <?php
                    
                        if($modelAsg->class == "All"){
                            echo '<input id="all_class" name="allClass" type="checkbox" value="all" disabled="true">Semua Kelas';
                        }else{
                            echo '<input id="all_class" name="allClass" type="checkbox" value="all">Semua Kelas';
                        }
                    
                    ?>
                    
                </div>
            </div>
        </div>
</div>

    <div class="row">
        <center>
            <?= Html::submitButton($modelAsg->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $modelAsg->isNewRecord ? 'btn-md btn-custom' : 'btn-md btn-custom btn-primary-edit', 'style' => 'padding: 8px 30px;width: 150px;']) ?>
        </center>   
    </div>

    <?php ActiveForm::end(); ?>

<?php
     $this->registerJs("
        var classCounter = 0;
        var url = window.location.href;
        var allCond = false;
        var classCond = '". $modelAsg->class ."';

        $(document).ready(function(){

            initDynamicForm();
            $('.class-error').hide();

            $('select[name=\"Class[0]\"]').change(function(){
                var classVal = $('select[name=\"Class[0]\"]').val();
    
                if(classVal === ''){
                    $('.label-error').addClass('active');
                    $('select[name=\"Class[0]\"]').addClass('border-error');
                    $('.class-error').show();
                    
                    event.preventDefault();
                }else{
                    $('.label-error').removeClass('active');
                    $('select[name=\"Class[0]\"]').removeClass('border-error');
                    $('.class-error').hide();
                }
            });

            $('#all_class').click(function(){
                allCond = !allCond;
            });

            if(url.search('create') != -1){
                $('#dynamic-form').submit(function(event){
                    var classVal = $('select[name=\"Class[0]\"]').val();
        
                    if(classVal === '' && allCond == false){
                        $('.label-error').addClass('active');
                        $('select[name=\"Class[0]\"]').addClass('border-error');
                        $('.class-error').show();
                        
                        event.preventDefault();
                    }else{
                        $('.label-error').removeClass('active');
                        $('select[name=\"Class[0]\"]').removeClass('border-error');
                        $('.class-error').hide();
                    }
                });
            }

            if(classCond == 'All'){
                $('select[name=\"Class[0]\"]').attr('disabled', 'true');
            }

        });

        function show(select_item) {
            if (select_item == 1) {
                hiddenDiv.style.visibility='visible';
                hiddenDiv.style.display='block';
                Form.fileURL.focus();
            } 
            else{
                hiddenDiv.style.visibility='hidden';
                hiddenDiv.style.display='none';
            }
        }

        function initDynamicForm(){
            if(sessionStorage.getItem('classList') === null){
                $.ajax({
                    url: '".\Yii::$app->urlManager->createUrl(['assignment/get-all-class'])."',
                    type: 'GET',
                    success: function(result){
                        var result = jQuery.parseJSON(result);
                        var classes = '';

                        classes += \"<option select='selected' value=''>Pilih Kelas...</option>\";
                        
                        result.forEach(function(classRes){
                            classes += \"<option value='\"+classRes['kelas_id']+\"'>\"+classRes['nama']+\"</option>\";
                        });

                        $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]'>\"+classes+\"</select><span class='class-error help-block help-block-error' display='none' aria-live='polite'>Kelas tidak boleh kosong</span></div></td></tr>\");
                        sessionStorage.setItem('classList', classes);
                    }
                });
            }else{
                var classes = sessionStorage.getItem('classList', classes);

                $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]'>\"+classes+\"</select><span class='class-error help-block help-block-error' display='none' aria-live='polite'>Kelas tidak boleh kosong</span></div></td></tr>\");
            }
        }

        function addMoreClass(){ 
            classCounter++;
            var classes = sessionStorage.getItem('classList');

            $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]'>\"+classes+\"</select></div></td></tr>\");
        }

        function removeClass(){
            if(classCounter > 0){
                $('tr[name=\"Class'+classCounter+'\"]').remove();
                classCounter--;
            }
        }

     ", $this::POS_END);

?>