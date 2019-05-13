<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use frontend\controllers\SiteController;
// $this->registerCssFile("././css/assignment.css");

$this->title = 'SIPPM Del';
$session = Yii::$app->session;
$this->registerCssFile("././css/project.css");
?>

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content">
    <div class=" container box-content">

        <div class="row" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        'Penggunaan Proyek',
                    ],
                ]);
            ?>
        </div>
        
        <h3><b>Permohonan Penggunaan Proyek</b></h3>
        <hr class="hr-custom">
        <div class="row">
            
            <div class="col-md-3" style="text-align: center;border-radius: 3px;">
            <ul class="nav nav-tabs" style="background-color: #6AC7C1;">
                <i style="display: block;    margin-top: 10px; color: #fff;"> Permohonan Anda </i>
                <li class="active"><a data-toggle="tab" href="#1" style="width: 262px;border-bottom: 1px solid #BDBDBD;padding: 15px;color: black;">Menunggu Ditanggapi &nbsp;&nbsp; <span class="badge"> <?= $modelRequestCount ?></span> </a></li>
                <li><a data-toggle="tab" href="#2" style="width: 262px;border-bottom: 1px solid #BDBDBD;padding: 15px;color: black;margin-bottom: 15px;"> Riwayat &nbsp;&nbsp; <span class="badge"> <?= $modelRiwayatCount ?> </span> </a></li>
                <?php
                    if($session['role'] != "Mahasiswa"){
                        echo '<i style="color: #fff;"> Permohonan user Lain </i>
                        <li><a data-toggle="tab" href="#3" style="width: 262px;border-bottom: 1px solid #BDBDBD;padding: 15px;color: black;"> Tanggapi Permohonan &nbsp;&nbsp; <span class="badge">' . $modelRequestUsersCount . '</span> </a></li>
                        <li><a data-toggle="tab" href="#4" style="width: 262px;padding: 15px;color: black;"> Riwayat &nbsp;&nbsp; <span class="badge"> '.$modelRiwayatRequestOrangLainCount .' </span> </a></li>';
                    }
                ?>
                <!-- <li class=""><a data-toggle="tab" href="#3" style="width:262px;border-bottom: 2px solid #eeecec;">Tanggapi Permohonan &nbsp;&nbsp; <span class="badge"> <?= $modelRequestCount ?></span> </a></li>
                <li><a data-toggle="tab" href="#4" style="width:262px;"> Riwayat &nbsp;&nbsp; <span class="badge"> <?= $modelRiwayatCount ?> </span> </a></li> -->
            </ul>


            </div>
            <div class="col-md-9" style="border-left: 1px solid #dad4d4;">

                

                        <?php
                            if($modelRequestUsersCount != 0 && $modelRequestCount != 0 && ($session['role'] == "Dosen" || $session['role'] == "Asisten Dosen")){
                                // echo '<div class="alert alert-info">
                                //             <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
                                //             <strong>Info!</strong> <br>
                                //             '. $modelRequestUsersCount.' request untuk ditanggapi, <br>
                                //             '. $modelRequestCount.' request anda dengan status menunggu tanggapan dari koordinator proyek.
                                //         </div>';
                                    echo '<div class="alert alert-danger">
                                            <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
                                            <strong>Info!</strong> <br>
                                            '.$modelRequestUsersCount.' permohonan untuk ditanggapi.
                                         </div>';
                                    echo '<div class="alert alert-info">
                                            <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
                                            <strong>Info!</strong> <br>
                                            '.$modelRequestCount.' permohonan anda dengan status menunggu tanggapan dari koordinator proyek.
                                        </div>';
                            }else if($modelRequestUsersCount != 0 && ($session['role'] == "Dosen" || $session['role'] == "Asisten Dosen")){
                                echo '<div class="alert alert-danger">
                                            <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
                                            <strong>Info!</strong> <br>
                                            '.$modelRequestUsersCount.' permohonan untuk ditanggapi.
                                        </div>';
                            }else if($modelRequestCount != 0){
                                echo '<div class="alert alert-info">
                                            <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
                                            <strong>Info!</strong> <br>
                                            '.$modelRequestCount.' permohonan anda dengan status menunggu tanggapan dari koordinator proyek.
                                        </div>';
                            }
                        ?>

                <div class="tab-content">
                    <div class="tab-pane fade in active " id="1">        

                        <table class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><h4><b>Permohonan Anda</b></h4></th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                if($modelRequestCount == 0){
                                    echo '<td class="empty-data-table"> <br> Tidak ada Permohonan saat ini.</td>';
                                }else{
                                    if($session['role'] == "Dosen" || $session['role'] == "Asisten Dosen"){
                                
                                    foreach($modelRequest as $request){
                                        $project = ProjectController::findModel($request['proj_id']);
                                        $status = ProjectUsageController::getProjectRequestStatus($request->sts_proj_usg_id);
                                        
                                            $updated_at = $request["updated_at"];
                                            $updated_at_timestamp = strtotime($updated_at);
                                            $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);  

                                            echo '<tr>
                                                    <td>';
                                                    echo '<ul style="padding: 0px;">';
                                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #FFF59D;">';
                                                    echo '<h5> <b> Request Anda </b> </h5>';
                                                    echo Html::a($project->proj_title, ['project-usage/view', 'id' => $request['proj_usg_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px;']);

                                                    echo '<span class="badge badge-primary badge-pill" style="background-color: #FFA726"> Status : 
                                                            '.$request->stsProjUsg->sts_proj_usg_name.'
                                                        </span>';
                                                    echo '<br>
                                                        <font style="color: #777777;">'.$updated_at.' </font>';
                                                    echo '
                                                    
                                                    <div style="float: right;">
                                                        <p>

                                                    ';
                                                    echo(
                                                        Html::a(" Edit", ["update", "proj_usg_id" => $request["proj_usg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 3px 10px;border-radius: 3px;']) .'&nbsp&nbsp' 
                                                        . Html::a('Batal', ["cancel", "proj_usg_id" => $request["proj_usg_id"]], ['class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 3px 10px;border-radius: 3px;', "data" => [
                                                            "confirm" => "Apakah anda yakin ingin  membatalkan permohonan penggunaan ini?",
                                                            "method" => "post",
                                                        ]]) 
                                                    );

                                                    echo '</p>
                                                    </div>';
                                                    
                                                    echo '<br>
                                                        <font href="#" data-toggle="collapse" data-target="#2'.$request['proj_usg_id'].'" onclick="find2()">
                                                            <span id="caret2" class="glyphicon glyphicon-chevron-down"></span>
                                                            Keterangan Penggunaan
                                                        </font>
                                                        <div id="2'.$request['proj_usg_id'].'" class="collapse">';
                                                            echo DetailView::widget([
                                                                'model' => $request,
                                                                'attributes' => [
                                                                    [
                                                                        'attribute' => 'proj_usg_creator',
                                                                        'label' => 'Direquest oleh'
                                                                    ],
                                                                    [
                                                                        'attribute' => 'proj.asg.asg_creator',
                                                                        'label' => 'Penerima Request'
                                                                    ],
                                                                    [
                                                                        'label' => 'Tujuan Penggunaan',
                                                                        'value' => function($model){

                                                                            return $this->context->getCategoryPenggunaan($model['cat_usg_id']);
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'proj_usg_usage',
                                                                        'label' => 'Keterangan Penggunaan',
                                                                        'format' => 'raw',
                                                                    ],
                                                                ]
                                                            ]);
                                                        echo '</div>';
                                                    echo '</li>';
                                                    echo '</ul>';
                                            echo '  </td>
                                                </tr>';
                                        
                                        }
                                    }
                                    
                                }
                            ?>

                            </tbody>
                        </table>

                    </div>

                    
                    <div class="tab-pane fade " id="3">        

                        <table class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><h4><b>Tanggapi Permohonan</b></h4></th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                if($modelRequestUsersCount == 0){
                                    echo '<td class="empty-data-table"> <br> Tidak ada permohonan untuk di tanggapi.</td>';
                                }else{
                                    if($session['role'] == "Dosen" || $session['role'] == "Asisten Dosen"){
                                        foreach($modelRequestUsers as $request){
                                            $status = ProjectUsageController::getProjectRequestStatus($request["sts_proj_usg_id"]);
                                            
                                                $updated_at = $request["updated_at"];
                                                $updated_at_timestamp = strtotime($updated_at);
                                                $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);  

                                                echo '<tr>
                                                        <td>';
                                                        echo '<ul style="padding: 0px;">';
                                                            echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #C5E1A5;">';

                                                            echo '<h5> <b> Tanggapi Permohonan </b> </h5>';
                                                            
                                                            echo Html::a($request['proj_title'], ['/project/view-project', 'proj_id' =>$request['proj_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px;']);
                        
                                                            echo '<br>
                                                                <font style="color: #777777;">Direquest oleh : '.$request['proj_usg_creator'].', '.$updated_at.' </font>';
                                                            echo '
                                                            
                                                            <div style="float: right;">
                                                                <p>
                        
                                                            ';
                                                            echo(
                                                                Html::a("Terima", ["accept-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-success btn-sm"]) .'&nbsp&nbsp'
                                                                . Html::a('Tolak', ["reject-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-danger btn-sm", "data" => [
                                                                    "confirm" => "Yakin untuk menolak permohonan penggunaan proyek berikut?",
                                                                    "method" => "post",
                                                                ]])
                                                            );
                        
                                                            echo '</p>
                                                            </div>';
                                                            
                                                            echo '<br>
                                                                <font href="#" data-toggle="collapse" data-target="#1'.$request['proj_usg_id'].'" onclick="find()">
                                                                <span id="caret1" class="glyphicon glyphicon-chevron-down"></span> Keterangan Penggunaan
                                                                    
                                                                </font>
                                                                <div id="1'.$request['proj_usg_id'].'" class="collapse">';
                                                                echo DetailView::widget([
                                                                    'model' => $request,
                                                                    'attributes' => [
                                                                        [
                                                                            'attribute' => 'proj_usg_creator',
                                                                            'label' => 'Direquest oleh'
                                                                        ],
                                                                        [
                                                                            'attribute' => 'asg_creator',
                                                                            'label' => 'Penerima Request'
                                                                        ],
                                                                        [
                                                                            'label' => 'Tujuan Penggunaan',
                                                                            'value' => function($model){
    
                                                                                return $this->context->getCategoryPenggunaan($model['cat_usg_id']);
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'proj_usg_usage',
                                                                            'label' => 'Keterangan Penggunaan',
                                                                            'format' => 'raw',
                                                                        ],
                                                                    ]
                                                                ]);
                                                            echo '</div>';
                                                            echo '</li>';
                                                        echo '</ul>';
                                                echo '  </td>
                                                    </tr>';
                                            
                                        }   
                                    }
                                }
                            ?>

                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade " id="2">
                        <h4><b>Riwayat Request Anda</b></h4>
                        <hr class="hr-custom">
                        <table class="table table-hover" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>  
                                    <th>#</th>
                                    <th>Proyek</th>
                                    <th>Koordinator</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if($modelRiwayatCount == 0){
                                    echo '<td class="empty-data-table" colspan=5> <br> Tidak ada riwayat Permohonan anda.</td>';
                                }else{
                                    foreach($modelRiwayat as $riwayat){
                                        $project = ProjectController::findModel($riwayat['proj_id']);
                                        $icon = $riwayat->stsProjUsg->sts_proj_usg_name == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                        echo '<tr>';
                                            echo '<td><b>'.$i.'</b></td>';
                                            echo "<td> ".Html::a($project->proj_title, ['/project/view-project', 'proj_id' => $project->proj_id], ['class' => 'text-title-list-project', 'style'=>'font-size:14px'])." </td>";
                                            echo '<td style="font-size: 12px;"> '.$riwayat->proj->asg->asg_creator.' </td>';
                                            echo '<td style="font-size: 12px;"> '.$icon .''.$riwayat->stsProjUsg->sts_proj_usg_name.' </td>';
                                            echo '<td> '.Html::a('Detail', ['project-usage/view', 'id' => $riwayat['proj_usg_id']], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 15px;font-size: 12px;']).' </td>';
                                        echo '</tr>';
                                        
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade " id="4">
                        <h4><b>Riwayat Request Sebagai Koordinator Proyek</b></h4>
                        <hr class="hr-custom">
                        <table class="table table-hover" id="dataTable3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Proyek</th>
                                    <th>Direquest oleh</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach($modelRiwayatRequestOrangLain as $riwayat2){
                                        $status = ProjectUsageController::getProjectRequestStatus($riwayat2["sts_proj_usg_id"]);
                                        $icon = $status == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                        echo '<tr>';
                                            echo '<td><b>'.$i.'</b></td>';
                                            echo "<td> ".Html::a($riwayat2['proj_title'], ['/project/view-project', 'proj_id' => $riwayat2['proj_id']], ['class' => 'text-title-list-project', 'style'=>'font-size:14px'])." </td>";
                                            echo '<td style="font-size: 12px;"> '.$riwayat2['proj_usg_creator'].' </td>';
                                            echo '<td style="font-size: 12px;"> '.$icon .' '.$status.' </td>';
                                            echo '<td> '.Html::a('Detail', ['project-usage/view', 'id' => $riwayat2['proj_usg_id']], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 15px;font-size: 12px;']).' </td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                                    
                                ?>
                            </tbody>
                        </table>

                    </div>

                </div>
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
            $("#dataTable1").DataTable({
            "pageLength": 3,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });
        $(function () {
            $("#dataTable2").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });
        $(function () {
            $("#dataTable3").DataTable({
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
