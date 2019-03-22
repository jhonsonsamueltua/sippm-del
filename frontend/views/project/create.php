<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

$this->title = 'Create Sippm Project';
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sippm-project-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
