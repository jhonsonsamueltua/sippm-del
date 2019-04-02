<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use common\models\CategoryProject;
use common\models\Course;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use common\models\Student;
?>
 
<div class="person-form">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Data Penugasan</th>
            </tr>
        </thead>
 
        <tbody >
            <tr >
                <td class="vcenter">
                    <?php $form = ActiveForm::begin(['options' => [
                        'enctype' => 'multipart/form-data',],
                        'layout' => 'horizontal',
                        'id' => 'dynamic-form',
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
                    
                    <?= $form->field($modelAsg, 'cat_proj_id')->dropDownList(ArrayHelper::map(CategoryProject::find()->all(), 'cat_proj_id', 'cat_proj_name'),
                                    ['prompt' => "Pilih Kategori"])->label("Kategori")?>
                    
                    <?= $form->field($modelAsg, 'asg_year')->textInput(['maxlength' => true])->label("Tahun") ?>

                    <?= $form->field($modelAsg, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"])->label("Matakuliah") ?>

                    <?= $form->field($modelAsg, 'asg_title')->textInput(['maxlength' => true])->label("Judul Proyek") ?>
                    
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
                    <?= $form->field($modelAsg, 'asg_description')->textarea(['rows' => 6])->hint('Max 500 characters.')->label("Deskripsi")?>
                
    

                    <div class="padding-v-md">
                        <div class="line line-dashed"></div>
                    </div>
                
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper',
                        'widgetBody' => '.container-items',
                        'widgetItem' => '.class-item',
                        'limit' => 10,
                        'min' => 1,
                        'insertButton' => '.add-class',
                        'deleteButton' => '.remove-class',
                        'model' => $modelsClsAsg[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'description',
                        ],
                    ]); ?>
                
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th style="width: 450px;">Mahasiswa</th>
                                <th class="text-center" style="width: 90px;">
                                <button type="button" class="add-class btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                                </th>
                            </tr>
                        </thead>
                
                        <tbody class="container-items">
                        <?php foreach ($modelsClsAsg as $indexClsAsg => $modelClsAsg): ?>
                            <tr class="class-item">
                                <td class="vcenter">
                                    <?php
                                        // necessary for update action.
                                        if (! $modelClsAsg->isNewRecord) {
                                            echo Html::activeHiddenInput($modelClsAsg, "[{$indexClsAsg}]asg_id");
                                        }
                                    ?>
                                
                                <?= $form->field($modelClsAsg, "[{$indexClsAsg}]class")->label(false)->dropDownList($listKelas, 
                                        ['prompt' => 'Pilih kelas ...', 
                                        'onchange' => '
                                            $.post( "index.php?r=assignment/lists&id='.'"+$(this).val(), function( data ) {
                                            $( "select#stu_id" ).html( data );
                                            });
                                            ']);
                                         ?>
                                </td>
                                <td>
                                <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_inner',
                                        'widgetBody' => '.container-students',
                                        'widgetItem' => '.student-item',
                                        'limit' => 3,
                                        'min' => 1,
                                        'insertButton' => '.add-student',
                                        'deleteButton' => '.remove-student',
                                        'model' => $modelsStuAsg[$indexClsAsg][0],
                                        'formId' => 'dynamic-form',
                                        'formFields' => [
                                            'Student'
                                        ],
                                    ]); ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NIM</th>
                                                <th class="text-center">
                                                    <button type="button" class="add-student btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="container-students">
                                        <?php foreach ($modelsStuAsg[$indexClsAsg] as $indexStuAsg => $modelStuAsg): ?>
                                            <tr class="student-item">
                                                <td class="vcenter">
                                                    <?php
                                                        // necessary for update action.
                                                        if (! $modelStuAsg->isNewRecord) {
                                                            echo Html::activeHiddenInput($modelStuAsg, "[{$indexStuAsg}][{$indexStuAsg}]cls_asg_id");
                                                        }
                                                    ?>
                                                    <?php
                                                        $dataStudent=ArrayHelper::map(Student::find()->asArray()->all(), 'stu_id', 'stu_fullname');
                                                    ?>
                                                    <?= $form->field($modelStuAsg, "[{$indexClsAsg}][{$indexStuAsg}]stu_id")->label(false)->dropDownList($dataStudent, ['prompt' => 'Pilih Mahasiswa..', 'id' => 'stu_id']) ?>
                                                </td>
                                                <td class="text-center vcenter" >
                                                    <button type="button" class="remove-student btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php DynamicFormWidget::end(); ?>
                                </td>
                
                                <td class="text-center vcenter" style="width: 90px; verti">
                                <button type="button" class="remove-class btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                                </td>
                
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                
                    <?php DynamicFormWidget::end(); ?>
                    <div class="form-group">
                        <?= Html::submitButton($modelAsg->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>