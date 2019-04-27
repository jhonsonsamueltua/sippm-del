<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\redactor\widgets\Redactor;
use common\models\CategoryProject;
use common\models\Course;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use common\models\Student;
?>
 
<div class="person-form">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="font-size: 25px;">Penugasan</th>
            </tr>
        </thead>
 
        <tbody >
            <tr >
                <td class="vcenter">
                    <?php $form = ActiveForm::begin(['options' => [
                        'enctype' => 'multipart/form-data',],
                        'id' => 'dynamic-form',
                        'enableClientValidation' => true,
                        'fieldConfig' => [
                            'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}\n{hint}",
                        ],
                    ]); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelAsg, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                                        ['prompt' => "Pilih Kategori", 'onchange' => 'java_script_:show(this.options[this.selectedIndex].value)'])->label("Kategori")?>    
                        </div>
                        <div class="col-md-6">
                            <!-- <?= $form->field($modelAsg, 'asg_year')->textInput(['maxlength' => true])->label("Tahun") ?> -->
                            <!-- <div id='hiddenDiv' hidden> -->
                                <?= $form->field($modelAsg, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"])->label("Matakuliah") ?>
                            <!-- </div> -->
                        </div>
                    </div>
                    
                    <?= $form->field($modelAsg, 'asg_title')->textInput(['maxlength' => true])->label("Judul Penugasan") ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                // $dateNow = date("Y-m-d H:i:s");
                            ?>
                            <?= 
                                $form->field($modelAsg, 'asg_start_time')->widget(DateTimePicker::class,[
                                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                    'options' => ['placeholder' => 'Pilih batas awal ...'],
                                    // 'value' => $dateNow,
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd hh:ii:ss'
                                    ]
                                    ])->label("Batas awal");
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= 
                                $form->field($modelAsg, 'asg_end_time')->widget(DateTimePicker::class,[
                                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                    'options' => ['placeholder' => 'Pilih batas akhir ...'],
                                    // 'value' => $dateNow,
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd hh:ii:ss'
                                    ]
                                    ])->label("Batas akhir");
                            ?>
                        </div>
                    </div>
                    
                    <?= $form->field($modelAsg, 'asg_description')->widget(Redactor::classname(), [
                            'options' => [
                                'minHeight' => 500,
                            ]
                        ]) ?>

                    <div class="padding-v-md">
                        <div class="line line-dashed"></div>
                    </div>

                    <div class="dynamic-asg-form">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Kelas</td>
                                    <td>
                                        <div class="col-md-10">
                                            Mahasiswa
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success btn-xs" onclick="addMoreClass()"><span class="glyphicon glyphicon-plus"></span></button>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="list-class"></tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <center>
                            <?= Html::submitButton($modelAsg->isNewRecord ? 'Kirim' : 'Update', ['class' => 'btn btn-primary', 'style' => 'width:100px;font-style: bold;']) ?>
                        </center>
                    </div>
                    <?php ActiveForm::end(); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
     $this->registerJs("
        var classCounter = 0;
        var studentCounter = [];

        $(document).ready(function(){
            fillArray();
            initDynamicForm();
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

                    $('#list-class').append(\"<tr><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='tr00'><td><div class='col-md-10 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-2'><button name='\"+classCounter+\"' type='button' class='btn btn-success btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button><button name='\"+classCounter+\"' type='button' class='btn btn-danger btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
                }
            });
        }

        function addMoreClass(){ 
            classCounter++;
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

                    $('#list-class').append(\"<tr><td><div class='form-group'><select class='form-control' name='Class[\"+classCounter+\"]' onchange='getAllStudentByClass(\"+classCounter+\")'>\"+classes+\"</select></div></td><td><table class='table'><tbody id='list-student\"+classCounter+\"'><tr name='tr00'><td><div class='col-md-10 form-group'><select name='Student[\"+classCounter+\"][0]' class='form-control'><option select='selected' value='empty'>Pilih Mahasiswa...</option></select></div><div class='col-md-2'><button name='\"+classCounter+\"' type='button' class='btn btn-success btn-xs' onclick='addMoreStudent(this)'><span class='glyphicon glyphicon-plus'></span></button><button name='\"+classCounter+\"' type='button' class='btn btn-danger btn-xs' onclick='removeStudent(this)'><span class='glyphicon glyphicon-minus'></span></button></div></td></tr></tbody></table></td></tr>\");
                }
            });
        }

        function addMoreStudent(element){
            var classIdx = element.name;
            var idName = 'list-student' + classIdx;

            if(studentCounter[classIdx] < 2){
                studentCounter[classIdx]++;
                
                $('#' + idName).append(\"<tr name='tr\"+classIdx+studentCounter[classIdx]+\"'><td><div class='col-md-10 form-group'><select name='Student[\"+classIdx+\"][\"+studentCounter[classIdx]+\"]' class='form-control'><option select='selected'>Pilih Mahasiswa...</option></select></div><div class='col-md-2'></div></td></tr>\");
            }
        }

        function removeStudent(element){
            var classIdx = element.name;
            var trName = classIdx + studentCounter[classIdx];

            if(studentCounter[classIdx] > 0){
                $('tr[name=\"tr'+trName+'\"]').remove();
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

            $.ajax({
                url: '". \Yii::$app->urlManager->createUrl(['assignment/get-all-students']) ."' + '&kelas_id=' + class_id,
                type: 'GET',
                success: function(result){
                    var result = jQuery.parseJSON(result);
                    var students = '';

                    students += \"<option select='selected' value='empty'>Pilih Mahasiswa...</option>\";
                    result.forEach(function(student){
                        students += \"<option value='\"+student['nim']+\"'>\"+student['nama']+\"</option>\";
                    });

                    $('select[name^=\"Student['+classId+']\"]').empty();
                    $('select[name^=\"Student['+classId+']\"]').append(students);
                }
            });
        }

     ", $this::POS_END);

?>