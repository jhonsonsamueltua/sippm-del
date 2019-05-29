<?php

/* @var $this yii\web\View */
use yiister\gentelella\widgets\Panel;
use yii\helpers\Html;
$this->title = 'My Yii Application';
use yii\widgets\DetailView;
use common\models\project;
use backend\controllers\SiteController;

// $this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

// $this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
// $this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
// $this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>
<div class="site-index">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">           -->

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

    <?php
        Panel::begin(
            [
                'header' => 'Proyek Berdasarkan Kategori',
                'icon' => 'list-alt',
            ]
        )
    ?>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                
            <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sub Kategori</th>
                    <th>Kategori</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                        foreach($modelCategory as $data){
                            echo '<tr>
                                    <td>
                                         '.$i.'       
                                    </td>
                                    <td>
                                        '.Html::a($data['sub_cat_proj_name'].' &nbsp;<span class="badge badge-info" style="background-color: #17a2b8">'.$data['count(sp.proj_id)'].'</span>', ['site/all-project', 'type' => $data['sub_cat_proj_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px; color: #03A9F4']).'
                                    </td>
                                    <td>
                                        '.$data['cat_proj_name'].'
                                    </td>
                                </tr>';
                            
                            $i++;
                        }
                    ?>
                </tbody>
            </table>

            </div>
        </div>
    <?php Panel::end() ?>

    
</div>

<?php
     $this->registerJs('
        $(function () {
            $("#dataTable").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });
     ', $this::POS_END);
?>