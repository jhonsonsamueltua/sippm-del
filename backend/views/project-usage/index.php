<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;

$this->title = 'SIPPM Del';
$session = Yii::$app->session;

?>
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content">
    <div class="box-content">
        <h3><b>Penggunaan Proyek</b></h3>
        <hr class="hr-custom">
        <div class="row">
            <div class="col-md-12" style="border-left: 1px solid #dad4d4;">
                <div class="tab-content">
                    <div class="tab-pane fade in active " id="1">
                        <div class="alert alert-info">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong>Info!</strong> <br>
                            <?= $modelRequestUsersCount ?> request untuk ditanggapi, <br>
                        </div>

                        <table class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>
                                        <h4><b>Request Penggunaan Proyek</b></h4>
                                    </th>
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

     ', $this::POS_END);
?>
