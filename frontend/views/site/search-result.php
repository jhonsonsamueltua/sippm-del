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


$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
// $this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<div class="body-content" style="font-size: 14px;">
    <div class="loader"></div>
    <div class=" container box-content">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        'Hasil Pencarian Proyek',
                    ],
                ]);
            ?>
        <br>
        
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
                        <?= "<input name='searchWords' type='text' placeholder='Keywords...' class='form-control' value='$searchKey'>" ?>
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
                        <button type="submit" class="btn form-control" style="background-image: linear-gradient(to right, #4f8cf3 0%, #6a11cb 100%); border: 0px; color: #fff;">Search</button>
                    </div>
                    <?php ActiveForm::end() ?>
            </div>
        </div>

        <div class="row">
            <?php
                Modal::begin([
                    'header' => '<h3>Advanced Search</h3>',
                    'headerOptions' => ['style' => 'color: #000; text-align: left;'], 
                    'toggleButton' => ['label' => 'Advanced Search >>', 'style' => 'float: right; background-color: rgba(0, 0, 0, 0); color: #3949AB; border: 0px; font-size: 18px; padding-right: 18px;'],
                ]);

                $advancedForm = ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(['advanced-search']),
                    'method' => 'get',
                ]);
                
                    echo("
                        <div class='form-group'>
                            <input name='advKeywords' class='form-control' placeholder='Keywords...' value='$searchKey'>
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
                        echo "<option value='$year->asg_year'>$year->asg_year</option>";
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
                            <input type='checkbox' name='keyword' value='KataKunci'><label style='color: #000; margin: 5px;'>Kata Kunci</label><br>
                        </fieldset>
                    ");

                    echo Html::submitButton('Search', ['class' => 'btn-search', 'style' => 'color: white;min-height: 40px;padding: 10px 20px;border-radius: 3px;margin-top: 20px;margin-bottom: 10px;']);

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
                                <?= Html::a($data['proj_title'], ['project/view-project', 'proj_id' => $data['id']], ['class' => 'text-title-project']) ?>
                                <font style="float: right;color:#641a3e;font-size: 1.3em;"><font data-toggle="tooltip" data-placement="top" title="Jumlah Penggunaan"><span class="fa fa-recycle"></span> <?= $data['proj_used']    ?></font></font>
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
        var spinner = $('.loader');

        $('#w0').submit(function(event){
            spinner.show();
        });

        $('#w2').submit(function(event){
            spinner.show();
        });

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
