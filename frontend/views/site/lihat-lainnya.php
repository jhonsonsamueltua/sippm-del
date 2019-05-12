<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'List Proyek';
?>

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">      
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

    <h4> <b>List Proyek "<?= $title ?>" </b> </h4>
    <hr class="hr-custom">

    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0" >
        <thead hidden>
        <tr>
            <th>Proyek <?= $title ?></th>
        </tr>
        </thead>
        <tbody>
            <?php
            if($modelCount == 0){
                echo '<td style="text-align: center"><i><br> Tidak ada proyek yang anda cari. </i></td>';
            }else{
                foreach($model as $data){
                    $description = $data['proj_description'];
                    $limit_words = 30;
                    $words = explode(' ',$description);
                    $description = implode(" ",array_splice($words,0,$limit_words));

                    $author = $data['proj_author'];
                    $author_words = explode(';', $author);
                    $author = implode("; ", $author_words);

                    $created_at = $data["updated_at"];
                    $old_date_timestamp = strtotime($created_at);
                    $created_at = date('l, d M Y', $old_date_timestamp); ?>

                    <tr>
                        <td style="border: 0px;padding: 0px 8px;">
                            <?= Html::a($data['proj_title'], ['project/view-project', 'proj_id' => $data['proj_id']], ['class' => 'text-title-project']) ?><font style="float: right;"><span class="glyphicon glyphicon-eye-open"></span> <?= 1?> &nbsp; <span class="glyphicon glyphicon-download"></span> <?= 1    ?></font>
                            <div class="text-author">
                                <?= $author ?> (<?= $created_at ?>)
                            </div>

                            <?= $description ?>...
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    </div>
</div>


<?php
     $this->registerJs('
        $(function () {
            $("#dataTable").DataTable({
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
