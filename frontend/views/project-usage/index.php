<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;

$this->title = 'SIPPM Del';
$session = Yii::$app->session;

?>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css "> -->
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content">
    <div class=" container box-content">
        <h3><b>Penggunaan Proyek</b></h3>
        <hr class="hr-custom">
        <div class="row">
            
            <div class="col-md-3" style="text-align: center;">

                <div class="vertical-menu nav nav-tabs">
                    <a class=" active" href="#1" data-toggle="tab">Request saat ini </a>
                    <a class="" href="#2" data-toggle="tab">  Riwayat Request Saya</a>
                    <a class="" href="#3" data-toggle="tab">  Unduhan </a>
                    <?php
                        if($session['role'] != "Mahasiswa"){
                            echo '<i> Tambahan </i>
                            <a class="" href="#4" data-toggle="tab"> Request <font style="font-size: 13px;"> (Sebagai Koordinator) </font> </a>';
                        }
                    ?>
                    
                </div>

            </div>
            <div class="col-md-9" style="border-left: 1px solid #dad4d4;">

                <div class="tab-content">
                    <div class="tab-pane fade in active " id="1">

                        <div class="alert alert-info">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong>Info!</strong> <br>
                            <?= $modelRequestUsersCount ?> request untuk ditanggapi, <br>
                            <?= $modelRequestCount ?> request anda dengan status menunggu tanggapan dari koordinator proyek.
                        </div>

                        <table class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><h4><b>Request Penggunaan Proyek</b></h4></th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                if($modelRequestUsersCount != 0){
                                    foreach($modelRequestUsers as $request){
                                        $status = ProjectUsageController::getProjectRequestStatus($request["sts_proj_usg_id"]);
                                        
                                        if($status == "Menunggu"){
        
                                            $updated_at = $request["updated_at"];
                                            $updated_at_timestamp = strtotime($updated_at);
                                            $updated_at = date('l, d M Y, H:i', $updated_at_timestamp);
                                            echo '<tr>
                                                    <td>';
                                                    echo '<ul style="padding: 0px;">';
                                                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';

                                                        echo '<h5> <b> Tanggapi Request user </b> </h5>';
                                                        
                                                        echo Html::a($request['proj_title'], ['/project/view-project', 'proj_id' =>$request['proj_id']], ['class' => 'text-title-project']);
                    
                                                        // echo '<span class="badge badge-primary badge-pill">
                                                        //         '.$status.'
                                                        //     </span>';
                                                        echo '<br>
                                                            <font style="color: #777777;">Direquest oleh : '.$request['proj_usg_creator'].', Tanggal request : '.$updated_at.' </font>';
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
                                                            <div id="1'.$request['proj_usg_id'].'" class="collapse">
                                                                
                                                                <br>
                                                                Direquest oleh : '.$request['proj_usg_creator'].'<br><br>
                                                                Kategori Penggunaan :'.$this->context->getCategoryPenggunaan($request['cat_usg_id']).'
                                                                <br>
                                                                <p>'.$request['proj_usg_usage'].'</p>
                                                            </div>
                                                        ';
                                                        echo '</li>';
                                                    echo '</ul>';
                                            echo '  </td>
                                                </tr>';
                                        
                                        }
                                        
                                    }   
                                }
                                if($modelRequestCount != 0){
                                    
                                    foreach($modelRequest as $request){
                                        $project = ProjectController::findModel($request['proj_id']);
                                        $status = ProjectUsageController::getProjectRequestStatus($request->sts_proj_usg_id);
                                        
                                        // if($status == "Menunggu"){

                                            $updated_at = $request["updated_at"];
                                            $updated_at_timestamp = strtotime($updated_at);
                                            $updated_at = date('l, d M Y, H:i', $updated_at_timestamp);
                                            echo '<tr>
                                                    <td>';
                                                    echo '<ul style="padding: 0px;">';
                                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                                    echo '<h5> <b> Request Saya </b> </h5>';
                                                    echo Html::a($project->proj_title, ['/project/view-project', 'proj_id' => $project->proj_id], ['class' => 'text-title-project']);

                                                    echo '<span class="badge badge-primary badge-pill">
                                                            '.$request->stsProjUsg->sts_proj_usg_name.'
                                                        </span>';
                                                    echo '<br>
                                                        <font style="color: #777777;">Tanggal request : '.$updated_at.' </font>';
                                                    echo '
                                                    
                                                    <div style="float: right;">
                                                        <p>

                                                    ';
                                                    echo(
                                                        Html::a(" Ubah", ["update", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-primary btn-sm"]) .'&nbsp&nbsp' 
                                                        . Html::a('Batal', ["cancel", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-danger btn-sm", "data" => [
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
                                                        <div id="2'.$request['proj_usg_id'].'" class="collapse">
                                                            
                                                            <br>
                                                            Koordinator Proyek : '.$request->proj->asg->asg_creator.'
                                                            <br><br>
                                                            Kategori Penggunaan : '.$request->catUsg->cat_usg_name.'
                                                            <p> '.$request->proj_usg_usage.' </p>
                                                        </div>
                                                    ';
                                                    echo '</li>';
                                                    echo '</ul>';
                                            echo '  </td>
                                                </tr>';
                                        
                                        // }
                                    }
                                }
                            ?>

                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade " id="2">
                        <table class="table table-hover" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Proyek</th>
                                    <th>Koordinator</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($modelRiwayat as $riwayat){
                                        $project = ProjectController::findModel($riwayat['proj_id']);
                                        $icon = $riwayat->stsProjUsg->sts_proj_usg_name == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                        echo '<tr>';
                                            echo "<td> ".Html::a($project->proj_title, ['/project/view-project', 'proj_id' => $project->proj_id], ['class' => 'text-title-project', 'style' => 'font-size: 15px'])." </td>";
                                            echo '<td> '.$riwayat->proj->asg->asg_creator.' </td>';
                                            echo '<td> '.$icon .' '.$riwayat->stsProjUsg->sts_proj_usg_name.' </td>';
                                            echo '<td> '.Html::a('Detail', ['project-usage/view', 'id' => $riwayat['proj_usg_id']], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']).' </td>';
                                        echo '</tr>';
                                    
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade " id="4">

                        <table class="table table-hover" id="dataTable3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Proyek</th>
                                    <th>Direquest oleh</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($modelRiwayatRequestOrangLain as $riwayat2){
                                        $status = ProjectUsageController::getProjectRequestStatus($riwayat2["sts_proj_usg_id"]);
                                        // $project = ProjectController::findModel($riwayat2['proj_id']);
                                        $icon = $status == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                        echo '<tr>';
                                            echo "<td> ".Html::a($riwayat2['proj_title'], ['/project/view-project', 'proj_id' => $riwayat2['proj_id']], ['class' => 'text-title-project', 'style' => 'font-size: 15px'])." </td>";
                                            echo '<td> '.$riwayat2['proj_usg_creator'].' </td>';
                                            echo '<td> '.$icon .' '.$status.' </td>';
                                            echo '<td> '.Html::a('Detail', ['project-usage/view', 'id' => $riwayat2['proj_usg_id']], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 20px;font-size: 13px;']).' </td>';
                                        echo '</tr>';
                                    
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
            "pageLength": 5,
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
            "pageLength": 5,
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
