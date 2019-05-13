<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $model->proj->proj_title;

$this->registerJsFile("././js/bootstrap.min.js", ['defer' => true]);
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" defer></script>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li>{link}</li>\n",
                    'links' => [
                        [
                            'label' => 'Penggunaan Proyek',
                            'url' => ['project-usage/index'],
                        ],
                        'Edit Penggunaan',
                    ],
                ]);
            ?>

        <h3><b> Edit Request Penggunaan</b> </h3>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'project' => $project,
        ]) ?>
    </div>
</div>
