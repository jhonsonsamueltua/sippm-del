<?php

  
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;
use frontend\controllers\SiteController;
use yii\widgets\DetailView;
use yiister\gentelella\widgets\Panel;
$this->title = 'SIPPM Del';
$session = Yii::$app->session;
?>
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>

<div class="body-content">
    <div class="box-content">
        <?php
            Panel::begin(
                [
                    'header' => 'Penggunaan Proyek',
                    'icon' => 'files-o',
                ]
            )
        ?>
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <h4>&nbsp;&nbsp;Riwayat Tanggapan Permohonan</h4>
                <hr class="hr-custom">
                <table class="table table-hover" id="dataTable1" width="100%" cellspacing="0">
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
                                echo '<tr><td class="empty-data-table" colspan=5 style="text-align: center"> <i><br> Tidak ada riwayat Permohonan anda.</i></td></tr>';
                            }else{
                                foreach($modelRiwayatRequestUsers as $riwayat2){
                                    $status = ProjectUsageController::getProjectRequestStatus($riwayat2["sts_proj_usg_id"]);
                                    // $icon = $status == "Diterima" ? '<i class="fa fa-check-circle-o" aria-hidden="true" style="color: #03A9F4"></i>' : '<i class="fa fa-times-circle-o" aria-hidden="true" style="color: #FF7043"></i>';


                                    echo '<tr>';
                                        echo '<td><b>'.$i.'</b></td>';
                                        echo "<td> ".Html::a('<font data-toggle="tooltip" data-placement="top" title="Lihat Proyek">'.$riwayat2['proj_title'].'</font>', ['/project/view-project', 'proj_id' => $riwayat2['proj_id']], ['class' => 'text-title-list-project', 'style'=>'font-size:14px'])." </td>";
                                        echo '<td style="font-size: 12px;"> '.$riwayat2['proj_usg_creator'].' </td>';
                                        echo '<td style="font-size: 12px;">'.$status.' </td>';
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
        <?php Panel::end() ?>
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
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
            });
        });

     ', $this::POS_END);
?>
