<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SippmProject */

// $this->title = 'Submit Proyek';
$this->params['breadcrumbs'][] = ['label' => 'Sippm Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="body-content" style="font-size: 14px;">
    <div class=" container box-content "> 

        <h3> <b>Submit Proyek</b> </h3>
        <hr class="hr-custom">

        <?= $this->render('_form', [
            'model' => $model,
            'assignment' => $assignment
        ]) ?>
    
    </div> 
</div>
