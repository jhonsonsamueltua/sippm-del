<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CategoryProject;
use common\models\SubCategoryProject;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CategoryProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$css = ['css/category-project.css'];
$this->title = 'Category Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    
    .subcat-error {
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

<div style="width: 80%">
    <div style="padding: 5px;">
        <h3>Kategori</h3>
        <hr>
        
        <?php
            Modal::begin([
                'header' => '<font style="font-size: 20px"><b>Tambah Kategori</b></font>',
                'toggleButton' => ['label' => 'Tambah Kategori', 'class' => ['btn btn-sm btn-success']],
            ]);
            
            $newCategory = new CategoryProject();
            $form = ActiveForm::begin([
                'action' => \yii\helpers\Url::to(['create']),
            ]);

            echo $form->field($newCategory, 'cat_proj_name')->textInput();

            echo Html::submitButton('Tambah', ['class' => 'btn btn-success', 'style' => 'text-align: right']);

            ActiveForm::end();

            Modal::end();
        ?>

        <?php
            foreach($categories as $category){
                $categoryId = $category->cat_proj_id;
                $categoryName = str_replace(' ', '', $category->cat_proj_name);

                echo("
                    <div class='col-md-12' style='background-color:#fff; border: 1px solid #fff; border-radius: 7px; padding: 5px; padding-left: 10px; margin-bottom: 10px;'>
                        <div class='row'>
                            <div class='col-md-5'>
                                <h4 href='#' data-toggle='collapse' data-target='#1$categoryName' onclick='changeIcon(\"$categoryName\")'>
                                    <span id='caret1$categoryName' class='glyphicon glyphicon-chevron-right'></span> $category->cat_proj_name
                                </h4>
                            </div>
                            <div class='col-md-7' style='padding-top: 6px;'>
                ");
                
                                Modal::begin([
                                    'header' => 'Ubah kategori ' . $category->cat_proj_name . '',
                                    'toggleButton' => ['label' => 'Ubah', 'class' => ['btn btn-sm btn-primary'], 'style' => 'padding: 4px 20px;'],
                                ]);

                                    $updatedCategory = CategoryProject::find()->where(['cat_proj_id' => $categoryId])->one();
                                    $formUpdateCategory = ActiveForm::begin([
                                        'action' => \yii\helpers\Url::to(['update', 'cat_proj_id' => $categoryId]),
                                    ]);

                                        echo $formUpdateCategory->field($updatedCategory, 'cat_proj_name')->textInput();

                                        echo Html::submitButton('Ubah', ['class' => 'btn btn-primary']);

                                    ActiveForm::end();

                                Modal:: end();
                
                echo("         
                                ". Html::a('Hapus', ['delete', 'cat_proj_id' => $categoryId], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'style' => 'padding: 4px 20px;',
                                    'data' => [
                                        'confirm' => 'Hapus kategori ' . $category->cat_proj_name . '?',
                                        'method' => 'POST'
                                    ]
                                ]) ."
                            </div>
                        </div>
                        
                        <div style='display: flex; justify-content: center;'>
                            <div id='1$categoryName' class='col-md-12 collapse' style='padding-left: 20px;'>
                    ");

                            echo '<hr>';
                     
                                Modal::begin([
                                    'header' => 'Tambah Sub Kategori',
                                    'toggleButton' => ['label' => 'Tambah '. $category->cat_proj_name .'', 'class' => ['btn btn-sm btn-success modal-btn']],
                                ]);

                                    $newSubCategory = new SubCategoryProject();
                                    $formSubCat = ActiveForm::begin([
                                        'action' => \yii\helpers\Url::to(['/sub-category-project/create', 'cat_proj_id' => $categoryId]),
                                    ]);

                                        echo("
                                            <input type='radio' name='form-type' value='dynamic' checked>Form Dinamis
                                            <input type='radio' name='form-type' value='file'>Import File
                                        ");

                                        echo("
                                            <br>
                                            <div id='dynamic-form'>
                                                <label class='label-error'>Nama Sub Kategori</label>
                                                <button onclick='addMoreSubKategori()' style='float: right;'>Tambah Field</button>
                                                <div id='dynamic-field' class='form-group'>    
                                                    <input class='form-control' type='text' name='SubKategori[0]'>
                                                    <p class='subcat-error'></p>
                                                </div>
                                            </div>
                                        ");

                                        echo $formSubCat->field($modelImport, 'fileImport')->fileInput();

                                        echo Html::submitButton('Tambah', ['class' => 'btn btn-success']);
                                        echo "<button class='btn btn-danger' data-dismiss='modal'>Batal</button>";

                                    ActiveForm::end();

                                Modal::end();
                                
                                echo("<br>");
                                
                                $subCategories = SubCategoryProject::find()->where(['cat_proj_id' => $categoryId])->andWhere('deleted!=1')->orderBy('sub_cat_proj_name ASC')->all();
                                foreach($subCategories as $subCategory){
                                    $subCategoryId = $subCategory->sub_cat_proj_id;
                                    $subCategoryName = $subCategory->sub_cat_proj_name;
                                    
                                    echo("
                                        <div class='col-md-9'>    
                                            <h4>$subCategoryName</h4>
                                        </div>
                                        <div class='col-md-3'>
                                    ");

                                        Modal::begin([
                                            'header' => 'Ubah Sub Kategori '. $subCategoryName .'',
                                            'toggleButton' => ['label' => 'Ubah', 'class' => ['btn btn-sm btn-primary']],
                                        ]);

                                            $updatedSubCategory = SubCategoryProject::find()->where(['sub_cat_proj_id' => $subCategoryId])->one();
                                            $formUpdateSubCategory = ActiveForm::begin([
                                                'action' => \yii\helpers\Url::to(['/sub-category-project/update', 'sub_cat_proj_id' => $subCategoryId]),
                                            ]);

                                                echo $form->field($updatedSubCategory, 'sub_cat_proj_name')->textInput();

                                                echo Html::submitButton('Ubah', ['class' => 'btn btn-primary']);

                                            ActiveForm::end();

                                        Modal::end();

                                    echo("". Html::a('Hapus', ['/sub-category-project/delete', 'sub_cat_proj_id' => $subCategoryId], [
                                                'class' => 'btn btn-sm btn-danger',
                                                'data' => [
                                                    'confirm' => 'Hapus sub kategori '. $subCategoryName . '?',
                                                    'method' => 'POST'
                                                ]
                                            ]) ."
                                        </div>
                                    ");
                                }
                echo("
                            </div>
                        </div>
                    </div>
                ");
            }
        ?>
    </div>

    <?php
        $this->registerJs("
            var formType = $('input[name=\"form-type\"]');
            var dynamicForm = $('#dynamic-form');
            var dynamicField = $('#dynamic-field');
            var fileForm = $('.field-dynamicmodel-fileimport');
            var subCatField = $('input[name=\"SubKategori[0]\"]');
            var fileField = $('#dynamicmodel-fileimport');
            var value = 'dynamic';
            var idx = 1;

            $(document).ready(function(){
                fileForm.hide();
            });

            formType.click(function(){
                value = $('input[name=\"form-type\"]:checked').val();

                if(value == 'dynamic'){
                    dynamicForm.show();
                    fileForm.hide();
                }else if(value == 'file'){
                    dynamicForm.hide();
                    fileForm.show();
                }
            });

            subCatField.focusout(function(){
                if(subCatField.val() == ''){
                    $('.label-error').addClass('active');
                    subCatField.addClass('border-error');
                    $('.subcat-error').html('Kata Kunci tidak boleh kosong');
                }else{
                    $('.label-error').removeClass('active');
                    subCatField.removeClass('border-error');
                    $('.subcat-error').html('');
                }
            });

            $('#w5').submit(function(event){
                if(value == 'dynamic'){
                    if(subCatField.val() == ''){
                        event.preventDefault();
                        dynamicForm.addClass('has-error');
                        dynamicForm.removeClass('has-success');
                        subCatField.attr('aria-invalid', 'true');
                        dynamicForm.find($('.help-block')).html('Nama Sub Kategori tidak boleh kosong');
                    }
                }else if(value == 'file'){
                    if(fileField.val() == ''){
                        event.preventDefault();
                        fileForm.addClass('has-error');
                        fileForm.removeClass('has-success');
                        fileField.attr('aria-invalid', 'true');
                        fileForm.find($('.help-block')).html('File tidak boleh kosong');
                    }
                }
            }); 

            function addMoreSubKategori(){
                var style = '';
                
                if(idx != 1){
                    style = 'margin-top: 10px;';
                }

                dynamicField.append(\"<input class='form-control' type='text' name='SubKategori[\"+idx+\"]' style='\"+style+\"'>\");
                idx++;
            }

            function changeIcon(caretName){
                var cond = $('#caret1'+caretName+'[aria-expanded]').attr('aria-expanded');
                
                $('#caret1'+caretName+'').toggleClass('glyphicon-chevron-down', cond);
                $('#caret1'+caretName+'').toggleClass('glyphicon-chevron-right', !cond);
                cond = !cond;
            }

        ", $this::POS_END);
    ?>

</div>