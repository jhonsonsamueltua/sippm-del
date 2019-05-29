<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

$this->title = 'List Proyek';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("././css/project.css");
$this->registerCssFile("././css/dataTables/dataTables.bootstrap.min.css");

$this->registerJsFile("././js/dataTables/jquery.dataTables.min.js", ['defer' => true]);
$this->registerJsFile("././js/dataTables/dataTables.bootstrap.min.js", ['defer' => true]);
$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);

?>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

        <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</li>\n",
                'links' => [
                    'Daftar Proyek Anda',
                ],
            ]);
        ?>
    
    <br>
    <h4> <b>Daftar Proyek Anda</b> </h4>
    <hr class="hr-custom">
    
    <?php
        $tempContent = "";
        foreach($model as $data){
            $unggah = $data->updated_at;
            $unggah_timestamp = strtotime($unggah);
            $tanggalUnggah = date('d M Y', $unggah_timestamp);
            $tempContent = $tempContent . '
            <tr>
                <td>'.Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id], ['class' => 'text-title-list-project']).'</td>
                <td> '.$tanggalUnggah.' </td>
                <td>'.$data->proj_author.'</td>
            </tr>
            ';
        }
    ?>

    <table class="table table-hover" id="dataTables" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Proyek</th>
            <th>Tanggal Diunggah</th>
            <th>Author</th>
        </tr>
        </thead>
        <tbody>
            <?= $tempContent ?>
        </tbody>
    </table>

    </div>
</div>


<?php
     $this->registerJs('
        $(function () {
            $("#dataTables").DataTable({
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
