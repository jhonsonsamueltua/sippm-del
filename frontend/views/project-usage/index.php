<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use frontend\controllers\SiteController;
$this->registerCssFile("././css/assignment.css");

$this->title = 'SIPPM Del';
$session = Yii::$app->session;
$this->registerCssFile("././css/project.css");
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<div class="body-content">
    <div class=" container box-content">

            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        'Penggunaan Proyek',
                    ],
                ]);
            ?>
        <br>
        <h4><b>Permohonan Penggunaan Proyek</b></h4>
        <hr class="hr-custom">
        <?php
            $activeRequestSaya = "";
            $activeRequestUsers = "";
            if($modelRequestUsersCount >= 1){
                $activeRequestUsers = "defaultOpen";
            }else{
                $activeRequestSaya = "defaultOpen";
            }
        
        ?>
        <div class="row">
            <div class="col-md-3" style="padding-bottom: 20px;">
                <div class="tab">
                    <button class="tab-head" > <b> Permohonan Anda </b> </button>
                    <button class="tablinks" onclick="openContent(event, '1')" id= "<?= $activeRequestSaya ?>" > Menunggu Ditanggapi &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRequestCount ?></span></button>
                    <button class="tablinks" onclick="openContent(event, '2')" >Riwayat Permohonan &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRiwayatCount ?> </span></button>

                    <?php
                    if($session['role'] != "Mahasiswa"){?>
                    <button class="tab-head" style="padding-top: 30px;"> <b> Sebagai Koordinator Proyek</b> </button>
                    <button class="tablinks" onclick="openContent(event, '3')" id="<?= $activeRequestUsers ?>" >Tanggapi Permohonan &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRequestUsersCount ?> </span></button>
                    <button class="tablinks" onclick="openContent(event, '4')">Riwayat Tanggapan &nbsp;&nbsp; <span class="badge" style="background-color: #00838F;float: right"> <?= $modelRiwayatRequestUsersCount ?> </span></button>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-9">

                <div id="1" class="tabcontent">

                    <table class="table " id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><b>Permohonan Anda</b></th>
                                <?php
                                    if($modelRequestCount == 0){
                                         echo '<th> </th>';
                                    }?>
                                
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            if($modelRequestCount == 0){
                                echo '<td class="empty-data-table" colspan=2> <br><div style="min-height: 205px;"> Tidak ada Permohonan saat ini.</div></td>';
                            }else{
                            
                                foreach($modelRequest as $request){
                                    $project = ProjectController::findModel($request['proj_id']);
                                    $status = ProjectUsageController::getProjectRequestStatus($request->sts_proj_usg_id);
                                    
                                        $updated_at = $request["updated_at"];
                                        $updated_at_timestamp = strtotime($updated_at);
                                        $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);  

                                        echo '<tr>
                                                <td style="border-top: 0px;">';
                                                echo '<ul style="padding: 0px;">';
                                                echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #efebc5">';
                                                echo '<font> <b> Request Anda </b> </font>';
                                                echo '<span class="badge " style="background-color: #FFA726"> Status : 
                                                        '.$request->stsProjUsg->sts_proj_usg_name.'
                                                    </span>';
                                                echo '<br>';
                                                echo Html::a('<font data-toggle="tooltip" data-placement="top" title="Lihat Proyek">'.$project->proj_title.'</font>', ['project-usage/view', 'id' => $request['proj_usg_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px;']);
                                                echo '<br>Tujuan Penggunaan : '.$this->context->getCategoryPenggunaan($request['cat_usg_id']).'';
                                                
                                                echo '
                                                
                                                <div style="float: right;padding-top: 9px;">
                                                    <p>

                                                ';
                                                echo(
                                                    Html::a(" Ubah", ["update", "proj_usg_id" => $request["proj_usg_id"]], ['class' => 'btn-md btn-primary btn-info-custom', 'style' => 'padding: 3px 10px;border-radius: 3px;']) .'&nbsp&nbsp' 
                                                    . Html::a('Batal', ["cancel", "proj_usg_id" => $request["proj_usg_id"]], ['class' => 'btn-md btn-danger btn-info-custom', 'style' => 'padding: 3px 10px;border-radius: 3px;', "data" => [
                                                        "confirm" => "Apakah anda yakin membatalkan permohonan penggunaan ini?",
                                                        "method" => "post",
                                                    ]]) 
                                                );

                                                echo '</p>
                                                </div>';
                                                
                                                echo '<br>
                                                        <font href="#" data-toggle="collapse" data-target="#1'.$request['proj_usg_id'].'" onclick="find()">
                                                        <span id="caret1" class="glyphicon glyphicon-chevron-down"></span> Detail Permohonan
                                                            
                                                        </font>
                                                        <div id="1'.$request['proj_usg_id'].'" class="collapse">';
                                                        echo DetailView::widget([
                                                            'model' => $request,
                                                            'attributes' => [
                                                                [
                                                                    'attribute' => 'proj_usg_usage',
                                                                    'label' => 'Keterangan Penggunaan',
                                                                    'format' => 'raw',
                                                                ],
                                                                [
                                                                    'attribute' => 'proj.asg.asg_creator',
                                                                    'label' => 'Penerima Permohonan',
                                                                    'value' => function($model){
                                                                        if($model->alternate == 1){
                                                                            return "Admin SIPPM Del (Dikarenakan koordinator proyek / ".$model->proj->asg->asg_creator." berstatus tidak aktif)";
                                                                        }else{
                                                                            return $model->proj->asg->asg_creator;
                                                                        }
                                                                    }
                                                                ],
                                                                [
                                                                    'label' => 'Tanggal Permohonan',
                                                                    'value' => function($model){
                                                                        $updated_at = $model["created_at"];
                                                                        $updated_at_timestamp = strtotime($updated_at);
                                                                        $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);

                                                                        return $updated_at;
                                                                    }
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
                        ?>

                        </tbody>
                    </table>

                </div>
                <div id="2" class="tabcontent" style="margin-top: 12px;">
                    
                    <b>Riwayat Permohonan Anda</b>
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
                                echo '<tr><td class="empty-data-table" colspan=5> <br> Tidak ada riwayat Permohonan anda.</td></tr>';
                            }else{
                                foreach($modelRiwayat as $riwayat){
                                    $project = ProjectController::findModel($riwayat['proj_id']);
                                    $icon = $riwayat->stsProjUsg->sts_proj_usg_name == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                    echo '<tr>';
                                        echo '<td><b>'.$i.'</b></td>';
                                        echo "<td> ".Html::a('<font data-toggle="tooltip" data-placement="top" title="Lihat Proyek">'.$project->proj_title.'</font>', ['/project/view-project', 'proj_id' => $project->proj_id], ['class' => 'text-title-list-project', 'style'=>'font-size:14px'])." </td>";
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
                <div id="3" class="tabcontent">

                    <table class="table " id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><b>Tanggapi Permohonan</b></th>
                                <?php
                                    if($modelRequestCount == 0){
                                         echo '<th> </th>';
                                    }?>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            if($modelRequestUsersCount == 0){
                                echo '<td class="empty-data-table" colspan=2> <br> Tidak ada permohonan untuk di tanggapi.</td>';
                            }else{
                                if($session['role'] == "Dosen" || $session['role'] == "Asisten Dosen"){
                                    foreach($modelRequestUsers as $request){
                                        $status = ProjectUsageController::getProjectRequestStatus($request["sts_proj_usg_id"]);
                                            echo '<tr>
                                                    <td style="border-top: 0px;">';
                                                    echo '<ul style="padding: 0px;">';
                                                        echo '<li class="list-group-item d-flex justify-content-between align-items-center" style="border: 1px solid #C5E1A5;">';

                                                        echo '<h5> <b> Tanggapi Permohonan </b> </h5>';
                                                        
                                                        echo Html::a('<font data-toggle="tooltip" data-placement="top" title="Lihat Proyek">'.$request['proj_title'].'</font>', ['/project/view-project', 'proj_id' =>$request['proj_id']], ['class' => 'text-title-project', 'style' => 'font-size: 16px;']);
                                                        echo '<br>Tujuan Penggunaan : '.$this->context->getCategoryPenggunaan($request['cat_usg_id']).'';
                                                        echo'
                                                        <div style="float: right;">
                                                            <p>
                    
                                                        ';
                                                        echo(
                                                            Html::a("Terima", ["accept-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-success btn-sm"]) .'&nbsp&nbsp'
                                                            . Html::a('Tolak', ["reject-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-danger btn-sm", "data" => [
                                                                "confirm" => "Apakah anda yakin menolak permohonan penggunaan ini?",
                                                                "method" => "post",
                                                            ]])
                                                        );
                    
                                                        echo '</p>
                                                        </div>';
                                                        
                                                        echo '<br>
                                                            <div href="#" data-toggle="collapse" data-target="#2'.$request['proj_usg_id'].'" onclick="find2()">
                                                            <span id="caret1" class="glyphicon glyphicon-chevron-down"></span> Detail Permohonan
                                                                
                                                            </div>
                                                            <div id="2'.$request['proj_usg_id'].'" class="collapse">';
                                                            echo DetailView::widget([
                                                                'model' => $request,
                                                                'attributes' => [
                                                                    [
                                                                        'attribute' => 'proj_usg_usage',
                                                                        'label' => 'Keterangan Penggunaan',
                                                                        'format' => 'raw',
                                                                    ],
                                                                    [
                                                                        'attribute' => 'proj_usg_creator',
                                                                        'label' => 'Direquest oleh'
                                                                    ],
                                                                    [
                                                                        'label' => 'Tanggal Permohonan',
                                                                        'value' => function($model){
                                                                            $updated_at = $model["created_at"];
                                                                            $updated_at_timestamp = strtotime($updated_at);
                                                                            $updated_at = SiteController::tgl_indo(date('Y-m-d', $updated_at_timestamp)).', '.date('H:i', $updated_at_timestamp);

                                                                            return $updated_at;
                                                                        }
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
                <div id="4" class="tabcontent" style="margin-top: 12px;">
                    
                    <b>Riwayat Tanggapan Permohonan</b>
                    <hr class="hr-custom">
                    <table class="table table-hover" id="dataTable4" width="100%" cellspacing="0">
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
                                if($modelRiwayatRequestUsersCount == 0){
                                    echo '<tr><td class="empty-data-table" colspan=5> <br> Tidak ada riwayat Permohonan anda.</td></tr>';
                                }else{
                                    foreach($modelRiwayatRequestUsers as $riwayat2){
                                        $status = ProjectUsageController::getProjectRequestStatus($riwayat2["sts_proj_usg_id"]);
                                        $icon = $status == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                        echo '<tr>';
                                            echo '<td><b>'.$i.'</b></td>';
                                            echo "<td> ".Html::a('<font data-toggle="tooltip" data-placement="top" title="Lihat Proyek">'.$riwayat2['proj_title'].'</font>', ['/project/view-project', 'proj_id' => $riwayat2['proj_id']], ['class' => 'text-title-list-project', 'style'=>'font-size:14px'])." </td>";
                                            echo '<td style="font-size: 12px;"> '.$riwayat2['proj_usg_creator'].' </td>';
                                            echo '<td style="font-size: 12px;"> '.$icon .' '.$status.' </td>';
                                            echo '<td> '.Html::a('Detail', ['project-usage/view', 'id' => $riwayat2['proj_usg_id']], ['class' => 'btn-xs btn-info btn-info-custom', 'style' => 'padding: 5px 15px;font-size: 12px;']).' </td>';
                                        echo '</tr>';
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
            "pageLength": 5,
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
            "pageLength": 5,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": true
            });
        });
        $(function () {
            $("#dataTable4").DataTable({
            "pageLength": 10,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });

        function openContent(evt, contentName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(contentName).style.display = "block";
            evt.currentTarget.className += " active";
          }
          
          // Get the element with id="defaultOpen" and click on it
          document.getElementById("defaultOpen").click();
     ', $this::POS_END);
?>
