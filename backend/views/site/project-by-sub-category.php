<?php

/* @var $this yii\web\View */
use yiister\gentelella\widgets\Panel;
$this->title = 'My Yii Application';
use yii\widgets\DetailView;
use common\models\Project;
use backend\controllers\SiteController;

$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>
<div class="site-index">
    <!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">           -->

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

    <?php
        Panel::begin(
            [
                'header' => $title,
                'icon' => 'list-alt',
            ]
        )
    ?>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                
            <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th>Proyek</th>
                    <th>Penulis</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        foreach ($project as $data) {
                            $modelProject = Project::find()->andwhere(['proj_id' => $data['proj_id']])->one();
                            ?>

                            <tr>
                                <td>
                                    <a href="#" data-toggle="collapse" data-target="#<?= $modelProject->proj_id ?>" onclick="find()" data-toggle="tooltip" data-placement="top" title="Lihat Detail Proyek">
                                        <span id="caret1" class="glyphicon glyphicon-chevron-down" style="color: blue;"></span> <?= $modelProject->proj_title ?>
                                    </a>
                                    <div id=<?= $modelProject->proj_id ?> class="collapse">
                                        <?php
                                            echo DetailView::widget([
                                                'model' => $modelProject,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'proj_title',
                                                        'label' => 'Judul',
                                                    ],
                                                    [
                                                        'attribute' => 'asg_id',
                                                        'label' => 'Kategori',
                                                        'value' => function($model){
                                                            return $model->asg->catProj->cat_proj_name.' - '.$model->asg->subCatProj->sub_cat_proj_name.', '.$model->proj_year;
                                                        }
                                                    ],
                                                    [
                                                        'attribute' => 'proj_description',
                                                        'label' => 'Deskripsi',
                                                        'format' => 'raw',
                                                    ],
                                                    [
                                                        'attribute' => '',
                                                        'label' => 'Kata Kunci',
                                                        'value' => "Masih Kosong",
                                                    ],
                                                    [
                                                        'attribute' => 'stsWin.sts_win_name',
                                                        'label' => 'Status Kompetisi',
                                                        'value' => function($model){
                                                            if($model->asg->catProj->cat_proj_name == "Kompetisi"){
                                                                return $model->stsWin->sts_win_name;
                                                            }else{
                                                                return "---";
                                                            }
                                                        }
                                                    ],
                                                    [
                                                        'attribute' => 'asg.asg_creator',
                                                        'label' => 'Koordinator Proyek',
                                                    ],
                                                    [
                                                        'attribute' => 'proj_creator',
                                                        'label' => 'Diunggah oleh',
                                                    ],
                                                    [
                                                        'attribute' => '',
                                                        'label' => 'Tanggal unggah',
                                                        'value' => function($model){
                                                            $updated_at = $model["created_at"];
                                                            $updated_at_timestamp = strtotime($updated_at);
                                                            $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);

                                                            return $updated_at;
                                                        }
                                                    ],
                                                ]
                                            ]);
                                        ?>
                                    </div>
                                </td>
                                <td><?= $modelProject->proj_author ?></td>
                            </tr>

                    <?php
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
    $this->registerJs("

    var change = true;
    $(document).ready(function () {
        $('[data-toggle=offcanvas]').click(function () {
            $('.row-offcanvas').toggleClass('active');
        });
    });

    function find() {
        $('#caret1').toggleClass('glyphicon-chevron-up', change);
        $('#caret1').toggleClass('glyphicon-chevron-down', !change);
        change = !change
    }

    
    
    ", $this::POS_END);
?>

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