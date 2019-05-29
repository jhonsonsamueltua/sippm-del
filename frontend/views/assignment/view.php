<?php
/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\models\ClassAssignment;
use common\models\StudentAssignment;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use frontend\controllers\SiteController;
use frontend\controllers\AssignmentController;

$this->title = $model->asg_title;
$this->registerCssFile("././css/assignment.css");
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
// $this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
?>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script> -->
<style>
    .unblock{
        display: -webkit-inline-box;
    }
</style>
<div class="body-content">
    <div class=" container box-content ">
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
        
        <p>
        <?php
            $button = "";
            
            if($model->sts_asg_id == 1 || $model->sts_asg_id == 3){
                $button = Html::a("Ubah", ["update", "id" => $model->asg_id], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 30px;']) .' &nbsp; &nbsp;'.
                Html::a("Batal", ["delete", "id" => $model->asg_id], [
                    'class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 5px 20px;',
                    "data" => [
                        "confirm" => "Apakah anda yakin membatalkan penugasan ini?",
                        "method" => "post",
                    ],
                ]).'&nbsp; &nbsp;';
            }
            echo $button;
            
            if($model->sts_asg_id == 2){
                echo '<div class="unblock">';
                Modal::begin([
                    'header' => '<h3>Re-Open Penugasan</h3>',
                    'toggleButton' => ['label' => 'Re-Open', 'class' => 'btn btn-primary btn-info-custom', 'style' => 'padding: 4px 15px; margin-bottom: 1px;border: 0px;'],
                    'size' => 'modal-md',
                ]);
                    
                    $modelAsg = AssignmentController::findModel($model->asg_id);    
                    $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['open-assignment', 'asg_id' => $modelAsg->asg_id])]);

                    echo $form->field($modelAsg, 'updated_end_time')->widget(DateTimePicker::class, [
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'pickerIcon' => '<i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 19px;color: #64B5F6"></i>',
                        'removeButton' => false,
                        'options' => ['placeholder' => 'Pilih batas akhir...',
                        'autocomplete'=>'off'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd hh:ii:ss'
                        ]
                    ])->label('Batas Akhir &nbsp;&nbsp;');
                    echo '<div style="text-align:center">';
                    echo '<br>';
                    echo Html::submitButton('Re-Open', ['class' => 'btn btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;border: 0px;']).'&nbsp;&nbsp;';
                    echo '&nbsp;&nbsp;'.Html::a("Batal", [''], ['data-dismiss' => 'modal', 'class' => 'btn btn-danger btn-info-custom', 'style' => 'padding: 5px 15px;border: 0px;']);
                    echo '</div>';

                    ActiveForm::end();

                Modal::end();
                echo '</div>&nbsp;&nbsp;&nbsp;';
            }
            
            echo Html::a('Kembali', ['assignment/assignment-dosen'], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 5px 15px;background-color:#607d8be3']);
        ?>
        
        </p>

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
                                try{
                                    if($model->class == "All"){
                                        return "Semua Kelas";
                                    }else{
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
                                    }
                                }catch(Exception $e){
                                    throw $e;
                                }
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

        $(function () {
            $('#dataTables').DataTable({
            'pageLength': 10,
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
            });
        });
    
    ", $this::POS_END);
?>


<?php
     $this->registerJs('
     $("form").submit(function(event){
        var value = $("#assignment-updated_end_time").val();
        
        if(value == ""){
            event.preventDefault();
            $(".field-assignment-updated_end_time").addClass("has-error");
            $(".field-assignment-updated_end_time").removeClass("has-success");
            $(".field-assignment-updated_end_time").find($(".help-block")).html("Batas Akhir tidak boleh kosong");
        }
    });
        
     ', $this::POS_END);
?>

