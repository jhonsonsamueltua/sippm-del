<?php
/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ClassAssignment;
use common\models\StudentAssignment;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use frontend\controllers\SiteController;

$this->title = $model->asg_title;
$this->registerCssFile("././css/assignment.css");
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content">
    <div class=" container box-content">

            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penugasan',
                            'url' => ['assignment/assignment-dosen'],
                        ],
                        'Detail Penugasan',
                    ],
                ]);
            ?>
        <br>
        <h4> <b>Detail Penugasan</b> </h4>
        <hr class="hr-custom">

        <?php
            $button = "";
            
            if($model->sts_asg_id == 1 || $model->sts_asg_id == 3){
                $button = '<p>'.Html::a("Ubah", ["update", "id" => $model->asg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 30px;']) .' &nbsp; &nbsp;'.
                Html::a("Batal", ["delete", "id" => $model->asg_id], [
                    'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 20px;',
                    "data" => [
                        "confirm" => "Apakah anda yakin membatalkan penugasan ini?",
                        "method" => "post",
                    ],
                ]).'</p>';
            }elseif($model->sts_asg_id == 2){
                // $button = '<p>'.Html::a('Open', ['assignment/view', 'id' => $model["asg_id"]], ['class' => 'btn-xs btn-custom', 'style' => 'padding: 5px 20px;font-size: 13px']).'</p>';
            }
            echo $button.'';
        ?>

        <div class="">
            <?php
                $asg_end_time = $model["asg_end_time"];
                $asg_end_time_timestamp = strtotime($asg_end_time);
                $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);

                $asg_start_time = $model["asg_start_time"];
                $asg_start_time_timestamp = strtotime($asg_start_time);
                $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp); 
            ?>
            <font style="font-size: px;margin: 15px 0px;display: block;color: #616161;"><b><?= $model->catProj->cat_proj_name ?> &nbsp;-&nbsp; <?= $model->subCatProj->sub_cat_proj_name ?> , <?= $model->asg_year ?> </b> </font>
            <font><b style="font-size: 22px;color: #03A9F4;"> <?= $model->asg_title ?></b></font>
            <div style="padding: 15px 0px;">
                <?= $model->asg_description ?>
            </div>

            <!-- <font>Status Penugasan : <?= $model->stsAsg->sts_asg_name ?></font> -->
            <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'stsAsg.sts_asg_name',
                            'label' => '<font style="padding-left: 0px;">Status Penugasan</font>',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => '',
                            'label' => 'Waktu Penugasan',
                            'value' => function($model){
                                $asg_end_time = $model["asg_end_time"];
                                $asg_end_time_timestamp = strtotime($asg_end_time);
                                $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);
                
                                $asg_start_time = $model["asg_start_time"];
                                $asg_start_time_timestamp = strtotime($asg_start_time);
                                $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp);
                                return $asg_start_time.' &nbsp;-&nbsp; '.$asg_end_time;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Tanggal Dibuat',
                            'value' => function($model){
                                $created_at = $model["created_at"];
                                $created_at_timestamp = strtotime($created_at);
                                $created_at = SiteController::tgl_indo(date('Y-m-d', $created_at_timestamp)).', '.date('H:i', $created_at_timestamp);

                                return $created_at;
                            }
                        ],
                        [
                            'attribute' => '',
                            'label' => 'Kelas Ditugaskan',
                            'value' => function($model){
                                // if($model->class == "All"){
                                //     return "Semua Kelas";
                                // }else{
                                    $class = "";
                                    $modelClass = ClassAssignment::find()->where(['asg_id' => $model->asg_id])->andWhere(['partial' => 0])->andWhere('deleted != 1')->all();

                                    foreach($modelClass as $key => $data){
                                        $data_class = $this->context->getClassByClassId($data->class);

                                        if($key == 0){
                                            $class = '<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">&nbsp;'.($key+1).". &nbsp;".$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                        }else{
                                            $class = $class.'<br>'.'<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.($key+1).'. &nbsp;'.$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                        }
                                    }
                                    return '<font style="font-size: px;">'.$class.'</font>';
                                // }
                            },
                            'format' => 'raw',
                        ],
                    ],
                ]) ?>
        </div>

        <h4><b>Proyek Mahasiswa 
            <span class="badge badge-primary" style="background-color: #6ac7c1"> <?= $projectsCount ?>  </span></b>
        </h4>
        <hr class="hr-custom">
        <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>#</th>
                <th>Judul Proyek</th>
                <th>Diunggah Oleh</th>
                <th>Kelas</th>
            </tr>
            </thead>
            <tbody>
                
                    <?php
                        if($projectsCount <= 0){
                            echo '<tr><td colspan=4> <center><br><i>Tidak ada proyek mahasiswa. </i></center> </td></tr>';
                        }else{
                            $i = 1;
                            foreach($projects as $data){
                    ?>  
                    <tr>
                        <td><b><?= $i ?></b></td>
                        <td>
                                <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]) ?>
                                
                            </div>
                        </td>
                        <td><?= $data->proj_creator ?></td>
                        <td>
                            <?php 
                                $data_class = $this->context->getClassByClassId($data['proj_creator_class']);
                                echo $data_class[0]['nama'];
                            ?>
                        </td>
                    </tr>
                    <?php
                        $i++;
                            }
                        }
                    ?>
                
            </tbody>
        </table>

    </div>
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

        function find2() {
            $('#caret2').toggleClass('glyphicon-chevron-up', change);
            $('#caret2').toggleClass('glyphicon-chevron-down', !change);
            change = !change
        }
    
    ", $this::POS_END);
?>


<?php
     $this->registerJs('
        $(function () {
            $("#dataTables").DataTable({
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

