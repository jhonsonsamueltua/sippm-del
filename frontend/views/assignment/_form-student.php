<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use common\models\Student;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-students',
    'widgetItem' => '.student-item',
    'limit' => 3,
    'min' => 1,
    'insertButton' => '.add-student',
    'deleteButton' => '.remove-student',
    'model' => $modelsStuAsg[0],
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
    <?php foreach ($modelsStuAsg as $indexStuAsg => $modelStuAsg): ?>
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