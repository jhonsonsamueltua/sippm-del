<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Course;
use common\models\CategoryProject;
use common\models\StudentAssignment;
use yii\redactor\widgets\Redactor;
use kartik\datetime\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;

$css = ['css/assignment-form.css'];
$session = Yii::$app->session;
?>

<div class="row">
    
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(['options' => [
            'enctype' => 'multipart/form-data',],
            'id' => 'dynamic-form',
            'enableClientValidation' => true,
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}\n{hint}",
            ],
        ]); ?>    
        
            <?= $form->field($modelAsg, 'asg_title')->textArea(['maxlength' => true])->label() ?>
            
            <?= $form->field($modelAsg, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                        ['prompt' => "Pilih Kategori", 'onchange' => 'java_script_:show(this.options[this.selectedIndex].value)'])->label()?>    

            <?= $form->field($modelAsg, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"])->label() ?>

            <?= $form->field($modelAsg, 'asg_start_time')->widget(DateTimePicker::class, [
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'options' => ['placeholder' => 'Pilih batas awal ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd hh:ii:ss'
                ],
                'class' => 'form-control'
            ])->label(); ?>

            <?= $form->field($modelAsg, 'asg_end_time')->widget(DateTimePicker::class, [
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Pilih batas akhir ...'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ])->label(); ?>

                <?= $form->field($modelAsg, 'asg_description')->widget(Redactor::classname(), [
                    'options' => [
                        'minHeight' => 500,
                    ]
                ]) ?>
    </div>
        
    <div class="col-md-6">
            <?php
                if(!$modelAsg->isNewRecord){
                    echo("
                        
                                <p>Kelas yang ditugaskan:</p>
                                <ul>
                    ");
                            foreach($modelClass as $class){
                                if(!$class->partial){
                                    echo "<li>" . $class->class .'&nbsp;&nbsp;&nbsp;'. Html::a('<span class="glyphicon glyphicon-minus">', ['remove-students-in-class', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $class->cls_asg_id], ['class' => 'btn btn-danger btn-xs']) .  "</li>";
                                }
                            }
                        echo("
                                </ul>
                            
                        ");
                        echo("
                            
                                <p>Mahasiswa yang ditugaskan:</p>
                                <ul>
                        ");
                            foreach($modelClass as $class){
                                if($class->partial){
                                    $modelStudent = StudentAssignment::find()->where(['cls_asg_id' => $class->cls_asg_id])->andWhere('deleted!=1')->all();

                                    foreach($modelStudent as $student){
                                        echo "<li>" . $student->stu_id . Html::a('<span class="glyphicon glyphicon-minus">', ['remove-student', 'asg_id' => $modelAsg->asg_id, 'cls_asg_id' => $class->cls_asg_id, 'nim' => $student->stu_id], ['class' => 'btn btn-danger btn-xs']) . "</li>";
                                    }
                                }
                            }
                    echo("      </ul> 
                            
                    ");
                } 
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Kelas</td>
                            <td>
                                <div class="col-md-9">
                                    Mahasiswa
                                </div>
                                <div class="col-md-3" style="padding: 5px">
                                    <button type="button" class="btn btn-success btn-xs" onclick="addMoreClass()" ><span class="glyphicon glyphicon-plus"></span></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="removeClass()" ><span class="glyphicon glyphicon-minus"></span></button>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody id="list-class">
                        
                    </tbody>
                </table>
    </div>
</div>

    <div class="row">
        <center>
            <!-- <?= Html::submitButton($modelAsg->isNewRecord ? 'Kirim' : 'Edit', ['class' => 'btn-md button btn-custom', 'style' => 'padding: 8px 30px;width: 300px;font-style: bold;']) ?> -->
            <?= Html::submitButton($modelAsg->isNewRecord ? 'Kirim' : 'Update', ['class' => 'btn btn-primary']) ?>
        </center>   
    </div>

    <?php ActiveForm::end(); ?>



<?php
     $this->registerJs("
        var classCounter = 0;
        var studentCounter = [];

        $(document).ready(function(){
            fillArray();
            initDynamicForm();
            $('#PenerimaTugas').hide();
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
                        
                        $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student00'><td><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;'' style='padding: 0px;'><button name='\"+classCounter+\"' type='button' class='btn btn-success btn-xs' onclick='addMoreStudent(this)' ><span class='glyphicon glyphicon-plus'></span></button><button name='\"+classCounter+\"' type='button' class='btn btn-danger btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
                        sessionStorage.setItem('classList', classes);
                    }
                });
            }else{
                var classes = sessionStorage.getItem('classList', classes);

                $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student00'><td><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''><button name='\"+classCounter+\"' type='button' class='btn btn-success btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button><button name='\"+classCounter+\"' type='button' class='btn btn-danger btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
            }
        }

        function addMoreClass(){ 
            classCounter++;
            var classes = sessionStorage.getItem('classList');

            $('#list-class').append(\"<tr name='Class\"+classCounter+\"'><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='Student\"+classCounter+\"0'><td><div class='col-md-9 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''><button name='\"+classCounter+\"' type='button' class='btn btn-success btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button><button name='\"+classCounter+\"' type='button' class='btn btn-danger btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
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
                    $('#' + idName).append(\"<tr name='Student\"+classIdx+studentCounter[classIdx]+\"'><td><div class='col-md-9 form-group'><select name='Student[\"+classIdx+\"][\"+studentCounter[classIdx]+\"]' class='form-control'><option select='selected'>Pilih Mahasiswa...</option></select></div><div class='col-md-3' style='padding: 0px;''></div></td></tr>\");
                }else{
                    var students = sessionStorage.getItem(class_id);

                    $('#' + idName).append(\"<tr name='Student\"+classIdx+studentCounter[classIdx]+\"'><td><div class='col-md-9 form-group'><select name='Student[\"+classIdx+\"][\"+studentCounter[classIdx]+\"]' class='form-control'>\"+students+\"</select></div><div class='col-md-3' style='padding: 0px;''></div></td></tr>\");
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

        function getAllStudentByClass(classId){
            var class_id = $('select[name=\"Class['+classId+']\"]').children('option:selected').val();

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

        function openTab(tabName){
            if(tabName == 'DeskripsiPenugasan'){
                $('button[name=\"tab2\"]').removeClass('active');
                $('#PenerimaTugas').hide();
                $('button[name=\"tab1\"]').addClass('active');
                $('#DeskripsiPenugasan').show();
            }else if(tabName == 'PenerimaTugas'){
                $('button[name=\"tab1\"]').removeClass('active');
                $('#DeskripsiPenugasan').hide();
                $('button[name=\"tab2\"]').addClass('active');
                $('#PenerimaTugas').show();
            }
        }

     ", $this::POS_END);

?>