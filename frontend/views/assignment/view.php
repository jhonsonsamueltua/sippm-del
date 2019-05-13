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

        <h3> <b>Detail Penugasan</b> </h3>
        <hr class="hr-custom">

        <?php
            $button = "";
            
            if($model->sts_asg_id == 1 || $model->sts_asg_id == 3){
                $button = '<p>'.Html::a("Edit", ["update", "id" => $model->asg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 30px;']) .' &nbsp; &nbsp;'.
                Html::a("Hapus", ["delete", "id" => $model->asg_id], [
                    'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 20px;',
                    "data" => [
                        "confirm" => "Apakah anda yakin menghapus penugasan ini?",
                        "method" => "post",
                    ],
                ]).'</p>';
            }elseif($model->sts_asg_id == 2){
                $button = '<p>'.Html::a('Open', ['assignment/view', 'id' => $model["asg_id"]], ['class' => 'btn-xs btn-custom', 'style' => 'padding: 5px 20px;font-size: 13px']).'</p>';
            }
            echo $button.'<br>';
        ?>

        <div class="row">
            <?php
                $asg_end_time = $model["asg_end_time"];
                $asg_end_time_timestamp = strtotime($asg_end_time);
                $asg_end_time = SiteController::tgl_indo(date('Y-m-d', $asg_end_time_timestamp)).', '.date('H:i', $asg_end_time_timestamp);

                $asg_start_time = $model["asg_start_time"];
                $asg_start_time_timestamp = strtotime($asg_start_time);
                $asg_start_time = SiteController::tgl_indo(date('Y-m-d', $asg_start_time_timestamp)).', '.date('H:i', $asg_start_time_timestamp); 
            ?>
            <div class="col-md-6">
                <b><?= $model->catProj->cat_proj_name ?> [ <?= $model->subCatProj->sub_cat_proj_name ?> ] </b>
                <h3><b style="font-size: 18px">Penugasan : <?= $model->asg_title ?></b></h3>
                <p>
                    <?= $model->asg_description ?>
                </p>
                <br>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [

                        // [
                        //     'attribute' => '',
                        //     'label' => 'Jumlah Proyek',
                        //     'value' => function($model){

                        //         return "10";
                        //     }
                        // ],
                        [
                            'attribute' => 'stsAsg.sts_asg_name',
                            'label' => 'Status Penugasan'
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
                                return $asg_start_time.' --- '.$asg_end_time;
                            }
                        ],
                        [
                            'attribute' => '',
                            'label' => 'Kelas Ditugaskan',
                            'value' => function($model){
                                $class = "";
                                $modelClass = ClassAssignment::find()->where(['asg_id' => $model->asg_id])->andWhere(['partial' => 0])->andWhere('deleted != 1')->all();

                                foreach($modelClass as $key => $data){
                                    $data_class = $this->context->getClassByClassId($data->class);

                                    if($key == 0){
                                        $class = '<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">&nbsp;'.($key+1).". ".$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                    }else{
                                        $class = $class.'<br>'.'<font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.($key+1).'. '.$data_class[0]['nama'].'</font> [ '.$data_class[0]['ket'].' ]';
                                    }
                                }
                                return '<font style="font-size: 12px;">'.$class.'</font>';
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => '',
                            'label' => 'Mahasiswa Ditugaskan',
                            'value' => function($model){
                                $student = "";
                                $query = "SELECT sa.stu_id, ca.class FROM sippm_student_assignment sa JOIN sippm_class_assignment ca ON sa.cls_asg_id = ca.cls_asg_id JOIN sippm_assignment sp ON ca.asg_id = sp.asg_id WHERE sp.asg_id = ".$model->asg_id." AND ca.partial = 1 AND sa.deleted != 1 GROUP BY sa.stu_id, ca.class ORDER BY ca.class ASC
                                ";
                                $modelStudent = Yii::$app->db->createCommand($query)->queryAll();

                                foreach($modelStudent as $key => $data){
                                    $data_student = $this->context->getStudentByNim($data['stu_id']);
                                    $data_class = $this->context->getClassByClassId($data['class']);

                                    if($key == 0){
                                        $student = '<font data-toggle="tooltip" data-placement="top" title="'.$data['stu_id'].'">&nbsp;'.($key+1).". ".$data_student.'</font> - <font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.$data_class[0]['nama'].'</font>';
                                    }else{
                                        $student = $student.'<font data-toggle="tooltip" data-placement="top" title="'.$data['stu_id'].'"><br>'.($key+1).'. '.$data_student.'</font> - <font data-toggle="tooltip" data-placement="top" title="'.$data_class[0]['ket'].'">'.$data_class[0]['nama'].'</font>';
                                    }
                                }
                                return '<font style="font-size: 12px;">'.$student.'</font>';
                            },
                            'format' => 'raw',
                        ],

                    ],
                ]) ?>

            </div>
            <div class="col-md-6">
                <h4><b><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp;Proyek Mahasiswa 
                    <span class="badge badge-primary" style="background-color: #6ac7c1"> <?= $projectsCount ?>  </span></b>
                </h4>
                <hr class="hr-custom">
                <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Diunggah oleh [ Proyek ]</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                            <?php
                                if($projectsCount <= 0){
                                    echo '<tr><td colspan=2> <br>Tidak ada proyek mahasiswa. </td></tr>';
                                }else{
                                    $i = 1;
                                    foreach($projects as $data){
                                        $num_char = 55 - strlen($data->proj_creator);
                                        if($num_char >= strlen($data->proj_title)){
                                            $title = $data->proj_title;    
                                        }else{
                                            $title = substr($data->proj_title, 0, $num_char) . '...';
                                        }
                            ?>  
                            <tr>
                                <td><b><?= $i ?></b></td>
                                <td>
                                
                                    <a href="#" data-toggle="collapse" data-target="#<?= $data->proj_id ?>" onclick="find()">
                                        <span id="caret1" class="glyphicon glyphicon-chevron-down"></span>
                                    </a>
                                    <?= $data->proj_creator ?> <?=  Html::a('[ '.$title.' ]', ['project/view-project', 'proj_id' => $data->proj_id]) ?> 
                                    <div id="<?= $data->proj_id ?>" class="collapse">
                                        <h5><b>Judul</b></h5>
                                        <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]) ?>
                                        <h5><b>Author</b></h5>
                                        <?= $data->proj_author ?>
                                    </div>
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
