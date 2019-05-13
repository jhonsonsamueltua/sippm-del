<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;

$this->title = 'List Proyek';
if(isset($_GET['searchWords'])){
    $searchKey = $_GET['searchWords'];
}else if(isset($_GET['advKeywords'])){
    $searchKey = $_GET['advKeywords'];
}else{
    $searchKey = '';
}

?>

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content" style="font-size: 14px;">

    <div class=" container box-content">
        
        <div class="row" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        'Hasil Pencarian Proyek',
                    ],
                ]);
            ?>
        </div><br>
        
        <h4><b>Hasil Pencarian Proyek</b></h4>
        <hr class="hr-custom">

        <h4>Search</h4>
        
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin([
                    'action' => ['search-project'],
                    'method' => 'get',
                ]); ?>
                    <div class="col-lg-5 col-md-5 col-sm-12 " style="padding: 0px;">
                        <?= "<input name='searchWords' type='text' placeholder='Keywords' class='form-control' value='$searchKey'>" ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                        <select name="searchCategory" placeholder="Category" class="form-control">
                            <option value="">Pilih Kategori</option>
                            <?php
                                foreach($categories as $category){
                                    echo("<option value='" . $category->cat_proj_name . "'>" . $category->cat_proj_name . "</option>");
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12" style="padding: 0px;">
                        <button type="submit" class="btn form-control" style="background: #6bc5c2; border: 0px; color: #fff;">Telusuri</button>
                    </div>
                    <?php ActiveForm::end() ?>
            </div>
        </div>

        <div class="row">
            <?php
                Modal::begin([
                    'header' => '<h3>Penelusuran Lanjutan</h3>',
                    'headerOptions' => ['style' => 'color: #000; text-align: left;'], 
                    'toggleButton' => ['label' => 'Penelusuran Lanjutan >>', 'style' => 'float: right; background-color: rgba(0, 0, 0, 0); color: #3949AB; border: 0px; font-size: 18px; padding-right: 18px;'],
                ]);

                $advancedForm = ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(['advanced-search']),
                    'method' => 'get',
                ]);
                
                    echo("
                        <div class='form-group'>
                            <input name='advKeywords' class='form-control' placeholder='Kata Kunci' value='$searchKey'>
                        </div>
                    ");
                    
                    echo("
                        <div class='form-group'>
                            <select id='adv-category' name='advCategory' class='form-control'>
                                <option value=''>Pilih Kategori</option>
                    ");
                            foreach($categories as $category){
                                echo("<option value='" . $category->cat_proj_name . "'>" . $category->cat_proj_name . "</option>");
                            }
                    echo(")
                            </select>
                        </div>
                    ");
                    
                    echo("
                        <div class='form-group'>
                            <select id='adv-sub-category' name='advSubCategory' class='form-control'>
                                <option value=''>Pilih Sub Kategori</option>
                            </select>
                        </div>
                    ");

                    echo("
                        <div class='form-group'>
                        <select name='advYear' class='form-control'>
                            <option value=''>Pilih Tahun Proyek</option>
                    ");
                        
                    foreach($yearList as $year){
                        echo "<option value='$year->proj_year'>$year->proj_year</option>";
                    }

                    echo("
                            </select>
                        </div>
                    ");

                    echo "<p style='color: #000; text-align: left;'>Cari berdasarkan:</p>";

                    echo("
                        <fieldset style='text-align: left;'>
                            <input type='checkbox' name='title' value='Judul'><label style='color: #000; margin: 5px;'>Judul</label><br>
                            <input type='checkbox' name='description' value='Deskripsi'><label style='color: #000; margin: 5px;'>Deskripsi</label><br>
                            <input type='checkbox' name='author' value='Penulis'><label style='color: #000; margin: 5px;'>Penulis</label><br>
                        </fieldset>
                    ");

                    echo Html::submitButton('Search', ['class' => 'btn']);

                ActiveForm::end();

                Modal::end();
            ?>
        </div><br>

        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0" >
            <thead hidden>
            <tr>
                <th>List Proyek</th>
            </tr>
            </thead>
            <tbody>
                <?php
                if($searchResCount == 0){
                    echo '<td style="text-align: center"><i><br> Tidak ada proyek yang anda cari. </i></td>';
                }else{
                    foreach($searchRes as $data){
                        $description = $data['proj_description'];
                        $limit_words = 30;
                        $words = explode(' ',$description);
                        $words = str_replace("<p>", "", $words);
                        $words = str_replace("</p>", "", $words);
                        
                        if(count($words) > 30){
                            $description = implode(" ",array_splice($words,0,$limit_words)).'...';
                        }else{
                            $description = implode(" ",array_splice($words,0,$limit_words));
                        }

                        $author = $data['proj_author'];
                        $author_words = explode(';', $author);
                        $author = implode("; ", $author_words);

                        $created_at = $data["updated_at"];
                        $old_date_timestamp = strtotime($created_at);
                        $created_at = date('l, d M Y', $old_date_timestamp); ?>

                        <tr>
                            <td style="border: 0px;padding: 0px 8px;">
                                <?= Html::a($data['proj_title'], ['project/view-project', 'proj_id' => $data['id']], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= 1?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= 1    ?></font>
                                <div class="text-author">
                                    <?= $author ?> (<?= $created_at ?>)
                                </div>

                                <p><?= $description ?></p>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
     $this->registerJs('
        
     $(function () {
            $("#dataTable").DataTable({
                "pageLength": 10,
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });

     ', $this::POS_END);

    $this->registerJs("

        var value = '';

        $('#adv-category').change(function(){
            value = ($('#adv-category').val() == '') ? 'Sub Kategori' : $('#adv-category').val();
            
            if(sessionStorage.getItem(value) === null){
                $.ajax({
                    url: '" . Yii::$app->urlManager->createUrl(['site/get-sub-category']) . "&categoryName=' + value,
                    type: 'GET',
                    success: function(result){
                        var result = jQuery.parseJSON(result);
                        var subCategories = '';

                        subCategories += \"<option value=''>Pilih \"+ value +\"</option>\"
                        result.forEach(function(subCategory){
                            subCategories += \"<option value='\"+ subCategory['sub_cat_proj_name'] +\"'>\"+ subCategory['sub_cat_proj_name'] +\"</option>\";
                        });
                    
                        $('#adv-sub-category').empty();
                        $('#adv-sub-category').append(subCategories);
                    
                        sessionStorage.setItem(value, subCategories);
                    }
                });
            }else{
                var subCategories = sessionStorage.getItem(value);

                $('#adv-sub-category').empty();
                $('#adv-sub-category').append(subCategories);
            }
            
        });

    ", $this::POS_END);

?>
