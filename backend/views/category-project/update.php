<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryProject */

$this->title = 'Update Category Project: ' . $model->cat_proj_id;
$this->params['breadcrumbs'][] = ['label' => 'Category Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cat_proj_id, 'url' => ['view', 'id' => $model->cat_proj_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
