<?php
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;
use yii\helpers\Html;
$session = Yii::$app->session;
$this->title = 'SIPPM Del';
$css = ['css/site.css'];
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="list-project-usage-request">
<br>    
<div class="body-content">
        <h2 class="text-h2">Penggunaan Proyek</h2>
        <hr class="hr-custom">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#requestPenggunaan">Request Penggunaan <span class="badge"> <?= $modelRequestCount ?> </span></a></li>
            <li><a data-toggle="tab" href="#riwayatPenggunaan">Riwayat Request Penggunaan <span class="badge"> <?= $modelRiwayatCount ?> </span></a></li>
        </ul>

        <div class="tab-content">
            <div id="requestPenggunaan" class="tab-pane fade in active">
                <ul class="list-group">

                    <?php
                        if($modelRequestCount == 0){
                            echo '<br><p><i> &nbsp;&nbsp;Tidak ada request penggunaan saat ini.</i></p>';
                        }else{
                            foreach($modelRequest as $request){
                                $status = ProjectUsageController::getProjectRequestStatus($request["sts_proj_usg_id"]);
                                
                                if($status == "Menunggu"){

                                    $updated_at = $request["updated_at"];
                                    $updated_at_timestamp = strtotime($updated_at);
                                    $updated_at = date('l, d M Y, H:i', $updated_at_timestamp);

                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                    
                                    echo Html::a($request['proj_title'], ['/project/view-project', 'proj_id' =>$request['proj_id']], ['class' => 'text-title']);

                                    echo '<span class="badge badge-primary badge-pill">
                                            '.$status.'
                                        </span>';
                                    echo '<br>
                                        <font style="color: #777777;">Direquest oleh : '.$request['proj_usg_creator'].', Tanggal request : '.$updated_at.' </font>';
                                    echo '
                                    
                                    <div style="float: right;">
                                        <p>

                                    ';
                                    echo(
                                        Html::a("Terima", ["accept-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-success btn-sm"]) .'&nbsp&nbsp'
                                    );

                                    Modal::begin([
                                        'header' => 'Tolak Permohonan Penggunaan',
                                        'toggleButton' => ['Tolak', ['class' => 'btn btn-danger btn-sm']],
                                    ]);

                                    Modal::end();
                                    //     . Html::a('Tolak', ["reject-request", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-danger btn-sm", "data" => [
                                    //         "confirm" => "Yakin untuk menolak permohonan penggunaan proyek berikut?",
                                    //         "method" => "post",
                                    //     ]])
                                    // );

                                    echo '</p>
                                    </div>';
                                    
                                    echo '<br>
                                        <a href="#" data-toggle="collapse" data-target="#'.$request['proj_usg_id'].'" onclick="find()">
                                            Keterangan Penggunaan
                                            <span id="caret1" class="glyphicon glyphicon-chevron-down"></span>
                                        </a>
                                        <div id="'.$request['proj_usg_id'].'" class="collapse">
                                            
                                            <br>
                                            Koordinator Proyek : '.$request['asg_creator'].'<br>
                                            Kategori Penggunaan :'.$this->context->getCategoryPenggunaan($request['cat_usg_id']).'
                                            <br>
                                            '.$request['proj_usg_usage'].'
                                        </div>
                                    ';
                                    echo '</li>';
                                
                                }
                                
                            }
                        }
                    ?>
                </ul>
            </div>
            <div id="riwayatPenggunaan" class="tab-pane fade">
                <ul class="list-group">

                    <?php
                        if($modelRiwayatCount == 0){
                            echo '<br><p><i> &nbsp;&nbsp;Tidak ada riwayat penggunaan saat ini.</i></p>';
                        }else{
                            foreach($modelRiwayat as $request){
                                $status = ProjectUsageController::getProjectRequestStatus($request["sts_proj_usg_id"]);
                                
                                if($status == "Diterima" || $status == "Ditolak"){

                                    $updated_at = $request["updated_at"];
                                    $updated_at_timestamp = strtotime($updated_at);
                                    $updated_at = date('l, d M Y, H:i', $updated_at_timestamp);

                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                    
                                    echo Html::a($request['proj_title'], ['/project/view-project', 'proj_id' =>$request['proj_id']], ['class' => 'text-title']);

                                    echo '<span class="badge badge-primary badge-pill">
                                            '.$status.'
                                        </span>';
                                    echo '<br>
                                        <font style="color: #777777;">Direquest oleh : '.$request['proj_usg_creator'].', Tanggal request : '.$updated_at.' </font>';
                                        echo '<br>
                                        <a href="#" data-toggle="collapse" data-target="#'.$request['proj_usg_id'].'" onclick="find2()">
                                            Keterangan Penggunaan
                                            <span id="caret2" class="glyphicon glyphicon-chevron-down"></span>
                                        </a>
                                        <div id="'.$request['proj_usg_id'].'" class="collapse">
                                            
                                            <br>
                                            Koordinator Proyek : '.$request['asg_creator'].'<br>
                                            Kategori Penggunaan :'.$this->context->getCategoryPenggunaan($request['cat_usg_id']).'
                                            <br>
                                            '.$request['proj_usg_usage'].'
                                        </div>
                                    ';
                                    echo '</li>';

                                }
                                
                            }
                        }
                    ?>
                </ul>
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