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

$this->title = $model->asg_title;
// $this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css "> -->
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content">
    <div class=" container box-content">
        <h3> <b>Detail Penugasan : <?= $model->asg_title ?></b> </h3>
        <hr class="hr-custom">

        <?php
            $button = "";
            
            if($model->sts_asg_id == 1 || $model->sts_asg_id == 3){
                $button = '<p>'.Html::a("Edit", ["update", "id" => $model->asg_id], ['class' => 'btn-sm btn-primary btn-info-custom', 'style' => 'padding: 5px 20px;']) .' &nbsp; &nbsp;'.
                Html::a("Hapus", ["delete", "id" => $model->asg_id], [
                    'class' => 'btn-sm btn-danger btn-info-custom', 'style' => 'padding: 5px 20px;',
                    "data" => [
                        "confirm" => "Apakah anda yakin menghapus penugasan ini?",
                        "method" => "post",
                    ],
                ]).'</p>';
            }elseif($model->sts_asg_id == 2){
                $button = '<p>'.Html::a('Open', ['assignment/view', 'id' => $model["asg_id"]], ['class' => 'btn-xs btn-custom', 'style' => 'padding: 5px 20px;font-size: 13px']).'</p>';
            }
            echo $button;
        ?>

        <div class="row">
            <?php
                $asg_end_time = $model["asg_end_time"];
                $asg_end_time_timestamp = strtotime($asg_end_time);
                $asg_end_time = date('l, d M Y, H:i', $asg_end_time_timestamp);

                $asg_start_time = $model["asg_start_time"];
                $asg_start_time_timestamp = strtotime($asg_end_time);
                $asg_start_time = date('l, d M Y, H:i', $asg_start_time_timestamp);
            ?>
            <div class="col-md-6">
                <h4> <b>Deskripsi :</b></h4>
                <?= $model->asg_description ?>
                    
                <h4> <b>Batas Penugasan :</b></h4>
                <?= $asg_start_time?> <b> --- </b> <?= $asg_end_time?>

                <h4> <b>Kategori :</b></h4>
                <?= $model->catProj->cat_proj_name ?> [ <?= $model->subCatProj->sub_cat_proj_name ?> ]

                <h4> <b>Status :</b></h4>
                <?= $model->stsAsg->sts_asg_name ?>

                <?php
                    $cls = "";
                    $modelClass = ClassAssignment::find()->where(['asg_id' => $model->asg_id])->all();
                    foreach($modelClass as $key => $data){
                        if($key == 0){
                            $cls = ($key+1).". ".$data->class;
                        }else{
                            $cls = $cls.'<br>'.($key+1).' '.$data->class;
                        }
                    }
                ?>
                <h4><b>Penerima Penugasan</b></h4>
                <?= $cls ?>

            </div>
            <div class="col-md-6">
                <h4><b>Submitan</b></h4>
                <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Diunggah oleh [ Proyek ]</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                foreach($projects as $data){
                                    $num_char = 62 - strlen($data->proj_creator);
                                    if($num_char >= strlen($data->proj_title)){
                                        $title = $data->proj_title;    
                                    }else{
                                        $title = substr($data->proj_title, 0, $num_char) . '...';
                                    }
                            ?>
                            <td>
                                <a href="#" data-toggle="collapse" data-target="#a" onclick="find()">
                                    <span id="caret1" class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <?= $data->proj_creator ?> <?=  Html::a('[ '.$title.' ]', ['project/view-project', 'proj_id' => $data->proj_id]) ?> 
                                <div id="a" class="collapse">
                                    <h5><b>Judul</b></h5>
                                    <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]) ?>
                                    <h5><b>Author</b></h5>
                                    <?= $data->proj_author ?>
                                </div>
                            </td>

                            <?php
                                }
                            ?>
                        </tr>
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
            "pageLength": 5,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });
     ', $this::POS_END);
?>
