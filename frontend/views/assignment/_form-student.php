<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

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
                        echo Html::activeHiddenInput($modelStuAsg, "[{$indexStuAsg}][{$indexStuAsg}]asg-id");
                    }
                ?>
                <?= $form->field($modelStuAsg, "[{$indexClsAsg}][{$indexStuAsg}]stu_id")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-student btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>