<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
$this->title = 'List Proyek';
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>


<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">
    
        <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</li>\n",
                'links' => [
                    'Proyek Kategori '.$category.'',
                ],
            ]);
        ?>
    <br>

    <h4> <b>Proyek Kategori "<?= $category ?>"</b> </h4>
    <hr class="hr-custom">

    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0"  >
        <thead>
        <tr>
            <th><?= $category ?> </th>
        </tr>
        </thead>
        <tbody>

                <?php
                    foreach($model as $data){
                        echo '<tr>
                                <td>
                                    '.Html::a($data['sub_cat_proj_name'].' &nbsp;<span class="badge badge-info" style="background-color: #17a2b8">'.$data['count_proj'].'</span>', ['project-by-sub-category', 'sub_cat' => $data['sub_cat_proj_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px; color: #03A9F4']).'
                                </td>
                            </tr>';
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
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });
     ', $this::POS_END);
?>
