<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategoryProject */

$this->title = 'Update Sub Category Project: ' . $model->sub_cat_proj_id;
$this->params['breadcrumbs'][] = ['label' => 'Sub Category Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sub_cat_proj_id, 'url' => ['view', 'id' => $model->sub_cat_proj_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-category-project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
