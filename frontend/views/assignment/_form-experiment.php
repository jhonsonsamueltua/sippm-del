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
                for($i = 2016; $i <= $year_now; $i++){
                    $year[$i] = $i;
                }
                
            ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($modelAsg, 'asg_year')->dropDownList($year)->label('Tahun') ?>  
                </div>
            </div>

            <?= $form->field($modelAsg, 'asg_title')->textArea(['maxlength' => true])->label() ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($modelAsg, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                        ['prompt' => "Pilih Kategori...", 
                        'onchange' => '
                            $.get( "index.php?r=assignment/lists&id='.'"+$(this).val(), function( data ) {
                            $( "select#sub_cat_proj_id" ).html( data );
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
                        // 'reuired' => true,
                    ],
                ]) ?>

                <br>
                <h4><b>Penerima Penugasan</b></h4>
                <!-- <hr class="hr-custom"> -->
                <?php
                    if(!$modelAsg->isNewRecord){
                        echo("<p>Kelas yang ditugaskan:</p> 
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
                                                    .Html::a('<span class="glyphicon glyphicon-minus">', ['remove-students-in-class', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $cls->cls_asg_id], ['class' => 'btn btn-danger-custom btn-xs']).
                                                '</div>
                                                <div class="col-md-11 col-sm-6 col-xs-6" style="padding: 4px 20px;">'
                                                .$class.
                                                '</div>
                                            </div>';
                                        // echo "<li>" . $class->class .'&nbsp;&nbsp;&nbsp;'. Html::a('<span class="glyphicon glyphicon-minus">', ['remove-students-in-class', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $class->cls_asg_id], ['class' => 'btn btn-danger-custom btn-xs']) .  "</li>";
                                        $i++;
                                    }
                                }
                        echo '</ul>';
                        echo("<p>Mahasiswa yang ditugaskan:</p>
                            <ul>");
                            foreach($modelClass as $class){
                                if($class->partial){
                                    $modelStudent = StudentAssignment::find()->where(['cls_asg_id' => $class->cls_asg_id])->andWhere('deleted!=1')->all();

                                    foreach($modelStudent as $key => $data){
                                        $data_student = $this->context->getStudentByNim($data->stu_id);
                                        $data_class = $this->context->getClassByClassId($data->classes->class);

                                        $student = "";
                                        if($key == 0){
                                            $student = '<font data-toggle="tooltip" data-placement="top" title="'.$data['stu_id'].'">&nbsp;'.''."".$data_student.'</font> - <font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.$data_class[0]['nama'].'</font>';
                                        }else{
                                            $student = $student.'<font data-toggle="tooltip" data-placement="top" title="'.$data['stu_id'].'">'.''.''.$data_student.'</font> - <font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.$data_class[0]['nama'].'</font>';
                                        }

                                        echo '<div class="row">
                                                <div class="col-md-1 col-sm-6 col-xs-6">'
                                                    .Html::a('<span class="glyphicon glyphicon-minus">', ['remove-student', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $class->cls_asg_id, 'nim' => $data->stu_id], ['class' => 'btn btn-danger-custom btn-xs']).
                                                '</div>
                                                <div class="col-md-11 col-sm-6 col-xs-6" style="padding: 4px 20px;">'
                                                .$student.
                                                '</div>
                                            </div>';
                                        // echo "<li>" . $student->stu_id . Html::a('<span class="glyphicon glyphicon-minus">', ['remove-student', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $class->cls_asg_id, 'nim' => $student->stu_id], ['class' => 'btn btn-danger-custom btn-xs']) . "</li>";
                                    }
                                }
                            }
                        echo '</ul>';
                    } 
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td class='label-error' style="font-weight: 700;">Kelas</td>
                            <td>
                                <div class="col-md-9" style="font-weight: 700;">
                                    Mahasiswa
                                </div>
                                <div class="col-md-3" style="padding: 0px">
                                &nbsp;<button type="button" class="btn btn-success-custom btn-xs" onclick="addMoreClass()" ><span class="glyphicon glyphicon-plus"></span></button>&nbsp; 
                                    <button type="button" class="btn btn-danger-custom btn-xs" onclick="removeClass()" ><span class="glyphicon glyphicon-minus"></span></button>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody id="list-class">
                        
                    </tbody>
                </table>

        </div>
            
        <!-- <div class="col-md-2">
            
        </div> -->
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
        var studentCounter = [];
        var url = window.location.href;

        $(document).ready(function(){
            fillArray();
            initDynamicForm();
            $('#PenerimaTugas').hide();
            $('.class-error').hide();
        });

        if(url.search('create') != -1){
            $('#dynamic-form').submit(function(event){
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
        }

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
                        
                        $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select required class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(this, \"+classCounter+\")'>\"+classes+\"</select><span class='class-error help-block help-block-error' display='none' aria-live='polite'>Kelas tidak boleh kosong</span></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student00'><td><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;'' style='padding: 0px;'><button name='\"+classCounter+\"' type='button' class='btn btn-success-custom btn-xs' onclick='addMoreStudent(this)' ><span class='glyphicon glyphicon-plus'></span></button>&nbsp;&nbsp;<button name='\"+classCounter+\"' type='button' class='btn btn-danger-custom btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
                        sessionStorage.setItem('classList', classes);
                    }
                });
            }else{
                var classes = sessionStorage.getItem('classList', classes);

                $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(this, \"+classCounter+\")'>\"+classes+\"</select><span class='class-error help-block help-block-error' display='none' aria-live='polite'>Kelas tidak boleh kosong</span></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student00'><td style='padding:0px;border-top:0px'><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''><button name='\"+classCounter+\"' type='button' class='btn btn-success-custom btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button>&nbsp;&nbsp;<button name='\"+classCounter+\"' type='button' class='btn btn-danger-custom btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
            }
        }

        function addMoreClass(){ 
            classCounter++;
            var classes = sessionStorage.getItem('classList');

            $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td style='padding:0px;border-top:0px'><div class='form-group'><select required class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td style='padding:0px;border-top:0px'><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student\"+classCounter+\"0'><td style='padding:0px;border-top:0px'><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''><button name='\"+classCounter+\"' type='button' class='btn btn-success-custom btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button>&nbsp;&nbsp;<button name='\"+classCounter+\"' type='button' class='btn btn-danger-custom btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
        }

        function removeClass(){
            if(classCounter > 0){
                $('tr[name=\"Class'+classCounter+'\"]').remove();
                classCounter--;
            }
        }

        function addMoreStudent(element){
            var classIdx = element.name;
            var idName = 'list-student' + classIdx;

            if(studentCounter[classIdx] < 5){
                var class_id = $('select[name=\"Class['+classIdx+']\"]').children('option:selected').val();
                
                studentCounter[classIdx]++;
                
                if(sessionStorage.getItem(class_id) === null){
                    $('#' + idName).append(\"<tr name='Student\"+classIdx+studentCounter[classIdx]+\"'><td style='padding:0px;border-top:0px'><div class='col-md-9 form-group'><select name='Student[\"+classIdx+\"][\"+studentCounter[classIdx]+\"]' class='form-control'><option select='selected'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''></div></td></tr>\");
                }else{
                    var students = sessionStorage.getItem(class_id);

                    $('#' + idName).append(\"<tr name='Student\"+classIdx+studentCounter[classIdx]+\"'><td style='padding:0px;border-top:0px'><div class='col-md-9 form-group'><select name='Student[\"+classIdx+\"][\"+studentCounter[classIdx]+\"]' class='form-control'>\"+students+\"</select></div><div class='col-md-3' style='padding: 0px;''></div></td></tr>\");
                }
            }
        }

        function removeStudent(element){
            var classIdx = element.name;
            var trName = classIdx + studentCounter[classIdx];

            if(studentCounter[classIdx] > 0){
                $('tr[name=\"Student'+trName+'\"]').remove();
                studentCounter[classIdx]--;
            }
        }

        function fillArray(){
            for(var i = 0; i <  10; i++){
                studentCounter[i] = 0;
            }
        }

        function getAllStudentByClass(element, classId){
            var class_id = $('select[name=\"Class['+classId+']\"]').children('option:selected').val();

            if(element.name === 'Class[0]'){
                var classVal = $('select[name=\"Class[0]\"]').val();

                if(classVal === ''){
                    $('.label-error').addClass('active');
                    $('select[name=\"Class[0]\"]').addClass('border-error');
                    $('.class-error').show();
                }else{
                    $('.label-error').removeClass('active');
                    $('select[name=\"Class[0]\"]').removeClass('border-error');
                    $('.class-error').hide();
                }
            }

            if(sessionStorage.getItem(class_id) === null){
                $.ajax({
                    url: '". \Yii::$app->urlManager->createUrl(['assignment/get-all-students']) ."' + '&kelas_id=' + class_id,
                    type: 'GET',
                    success: function(result){
                        var result = jQuery.parseJSON(result);
                        var students = '';
    
                        students += \"<option select='selected' value='empty'>Pilih Mahasiswa...</option>\";
                        result.forEach(function(student){
                            students += \"<option value='\"+student['nim']+\"'>\"+student['nama']+\" (\"+student['nim']+\")</option>\";
                        });
    
                        $('select[name^=\"Student['+classId+']\"]').empty();
                        $('select[name^=\"Student['+classId+']\"]').append(students);
                        sessionStorage.setItem(class_id, students);
                    }
                });
            }else{
                var students = sessionStorage.getItem(class_id);

                $('select[name^=\"Student['+classId+']\"]').empty();
                $('select[name^=\"Student['+classId+']\"]').append(students);
            }
        }

     ", $this::POS_END);

?>