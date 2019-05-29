<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubCategoryProject */

$this->title = 'Create Sub Category Project';
$this->params['breadcrumbs'][] = ['label' => 'Sub Category Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-category-project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
