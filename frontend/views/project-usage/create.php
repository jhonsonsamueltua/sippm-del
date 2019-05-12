<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\ProjectUsage */

$this->title = $project->proj_title;
$this->params['breadcrumbs'][] = ['label' => 'Project Usages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$css = ['css/site.css'];
?>
<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content">

        <div class="row" style="float:right;">
            <?php
                echo Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n",
                    'links' => [
                        [
                            'label' => 'Penggunaan Proyek',
                            'url' => ['project-usage/index'],
                        ],
                        'Request Penggunaan',
                    ],
                ]);
            ?>
        </div>

        <h4><b> Request Penggunaan</b> </h4>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'project' => $project,
        ]) ?>
    </div>
</div>
