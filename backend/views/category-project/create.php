<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryProject */

$this->title = 'Create Category Project';
$this->params['breadcrumbs'][] = ['label' => 'Category Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
