<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'List Proyek';
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
?>
<div class="sippm-project-index">
<br>
    <h2 class="text-h2"><?= Html::encode($this->title) ?></h2>
    <hr class="hr-custom">
    
    <?php
        $tempContent = "";
        foreach($model as $data){
            $tempContent = $tempContent . '
            <tr>
                <td>'.$data->proj_author.'</td>
                <td>'.Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]).'</td>
            </tr>
            ';
        }
    ?>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Author</th>
            <th>Proyek</th>
        </tr>
        </thead>
        <tbody>
            <?= $tempContent ?>
        </tbody>
    </table>

</div>
<br>