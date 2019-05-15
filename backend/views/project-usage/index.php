<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;
use frontend\controllers\SiteController;
use yii\widgets\DetailView;
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
            <div class="col-md-12">
                <table class="table " id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><h4>Tanggapi Permohonan</h4></th>
                            <?php
                                if($modelRequestUsersCount == 0){
                                        echo '<th> </th>';
                                }?>
                        </tr>
                    </thead>
                        <tbody>

                        <?php
                            if($modelRequestUsersCount == 0){
                                echo '<tr><td class="empty-data-table" colspan=2 style="text-align: center"> <i><br> Tidak ada riwayat Permohonan untuk ditanggapi.</i></td></tr>';
                            }else{
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
                                                                "confirm" => "Yakin untuk menolak permohonan penggunaan proyek berikut?",
                                                                "method" => "post",
                                                            ]])
                                                        );
                    
                                                        echo '</p>
                                                        </div>';
                                                        
                                                        echo '<br>
                                                            <div href="#" data-toggle="collapse" data-target="#'.$request['proj_usg_id'].'" onclick="find()">
                                                            <span id="caret1" class="glyphicon glyphicon-chevron-down"></span> Detail Permohonan
                                                                
                                                            </div>
                                                            <div id="'.$request['proj_usg_id'].'" class="collapse">';
                                                            echo '<br>';
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
                                                                        'attribute' => 'asg_creator',
                                                                        'label' => 'Koordinator Proyek',
                                                                        'value' => function($model){
                                                                            return $model['asg_creator'].' (Status tidak aktif)';
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
