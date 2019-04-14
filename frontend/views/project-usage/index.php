<?php

  
use yii\helpers\Html;
use frontend\controllers\ProjectUsageController;
use frontend\controllers\ProjectController;

$this->title = 'SIPPM Del';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="list-project-usage-request">

    <div class="body-content">
        <h2>Request Penggunaan Mahasiswa:</h2><br>
        <?php
            foreach($requests as $request){
                $project = ProjectController::findModel($request['proj_id']);
                $status = ProjectUsageController::getProjectRequestStatus($request->sts_proj_usg_id);
                
                echo('
                    <div class="row" style="color: #fff">
                        <div class="col-md-12" style="background: #0c5281; border-style:solid; border-color: #fff; border-width: 2px; border-radius: 10px; margin-bottom: 5px;">
                            <div class="col-md-8">
                                <h3>'. Html::a($project->proj_title, ['/project/view-project', 'proj_id' => $project->proj_id]) .'</h3>
                                <h5>Keterangan Penggunaan:</h5>
                                '. $request->proj_usg_usage .'<br>
                            </div>
                            <div class="col-md-4">
                                <h5>Direquest Oleh: '. $request->created_by .'</h5>
                                <h5>Status: '. $status .'</h5>
                            </div>
                        </div>
                ');
                if($status == "Menunggu"){
                    echo('
                        <div>
                            <p>'
                                . Html::a("Ubah", ["update", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-warning"]) .'&nbsp&nbsp' 
                                . Html::a('Batal', ["cancel", "proj_usg_id" => $request["proj_usg_id"]], ["class" => "btn btn-danger", "data" => [
                                    "confirm" => "Apakah anda yakin ingin  membatalkan permohonan penggunaan ini?",
                                    "method" => "post",
                                ]]) 
                            .'</p>
                        </div>
                    </div>
                    ');
                }
            }
        ?>
    </div>

</div>
