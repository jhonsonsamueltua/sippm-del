<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
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
                            <div id='hiddenDiv' hidden>
                                <?= $form->field($modelAsg, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'course_id', 'course_name'), ["prompt" => "Pilih Matakuliah"])->label("Matakuliah") ?>
                            </div>
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

                    <!-- <?= $form->field($modelAsg, 'asg_description')->textarea(['rows' => 6])->hint('Max 500 karakter.')->label("Deskripsi")?> -->
                
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
                
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="font-size: 18px;">Kelas</th>
                                <th style="width: 60%; font-size: 17px;">Mahasiswa</th>
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
                                        if (!$modelClsAsg->isNewRecord) {
                                            echo Html::activeHiddenInput($modelClsAsg, "[{$indexClsAsg}]asg_id");
                                        }
                                    ?>
                                    
                                    <?= $form->field($modelClsAsg, "[{$indexClsAsg}]class")->label(false)->dropDownList($listKelas, [
                                        'prompt' => 'Pilih kelas ...', 
                                        'onchange' => '
                                            $.get("index.php?r=assignment/lists&id='.'"+$(this).val(), function(data) {
                                                $("select[id^=studentassignment-'. $indexClsAsg .']").html(data);
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
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th style="font-size: 15px;">NIM</th>
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
                                                    
                                                    <?= $form->field($modelStuAsg, "[{$indexClsAsg}][{$indexStuAsg}]stu_id")->label(false)->dropDownList(['prompt' => 'Pilih Mahasiswa..']) ?>
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
                        <center>
                            <?= Html::submitButton($modelAsg->isNewRecord ? 'Kirim' : 'Update', ['class' => 'btn btn-primary', 'style' => 'width:100px;font-style: bold;']) ?>
                        </center>

                        <?php
                            if($modelAsg->sts_asg_id == 2){
                                Modal::begin([
                                    'header' => '<h2>Buka penugasan kembali?</h2>',
                                    'toggleButton' => ['label' => 'Perpanjang Penugasan', 'class' => 'btn btn-success'],
                                ]);

                                $form = ActiveForm::begin(['action' => Url::to(['testtest', 'id' => $modelAsg->asg_id])]);
                                
                                echo $form->field($modelAsg, 'asg_end_time')->widget(DateTimePicker::class,[
                                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                    'options' => ['placeholder' => 'Pilih batas akhir ...'],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd hh:ii:ss'
                                    ]
                                ])->label("Batas akhir");

                                echo Html::submitButton('Buka', ['class' => 'btn btn-success']);
                                
                                ActiveForm::end();

                                Modal::end();
                            }
                        ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
     $this->registerJs("
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
     ", $this::POS_END);
?>