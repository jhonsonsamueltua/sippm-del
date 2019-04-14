<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ClassAssignment;
use common\models\StudentAssignment;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = $model->asg_title;
$this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->asg_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->asg_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'asg_id',
                'label' => 'ID Penugasan'],
            ['attribute' => 'asg_title',
                'label' => 'Judul Penugasan'],
            ['attribute' => 'asg_description',
                'label' => 'Deskripsi Penugasan'],
            ['attribute' => 'asg_start_time',
                'label' => 'Batas Awal'],
            ['attribute' => 'asg_end_time',
                'label' => 'Batas Akhir'],
            ['attribute' => 'asg_year',
                'label' => 'Tahun'],
            ['attribute' => 'catProj.cat_proj_name',
                'label' => 'Kategori'],
            ['attribute' => 'course.course_name',
                'label' => 'Matakuliah'],
            ['attribute' => 'stsAsg.sts_asg_name',
                'label' => 'Status'],
            ['attribute' => 'class',
                'label' => 'Kelas',
                'format' => 'raw',
                'value' => function($model){
                    $cls = "";
                    $modelClass = ClassAssignment::find()->where(['asg_id' => $model->asg_id])->all();
                    foreach($modelClass as $key => $data){
                        if($key == 0){
                            $cls = ($key+1)." ".$data->class;
                        }else{
                            $cls = $cls.'<br>'.($key+1).' '.$data->class;
                        }
                    }
                        return $cls;
                    }
                ],
                // ['attribute' => '',
                // 'label' => 'Mahasiswa',
                // 'format' => 'raw',
                // 'value' => function($model){
                //     $stu = "";
                //     $modelStudent = StudentAssignment::find()->where(['asg_id' => $model->asg_id])->all();
                //     foreach($modelStudent as $key => $data){
                //         if($key == 0){
                //             $stu = ($key+1)." ".$data->stu->stu_fullname;
                //         }else{
                //             $stu = $stu.'<br>'.($key+1)." ".$data->stu->stu_fullname;
                //         }
                //     }
                //         return $stu;
                //     }
                // ]
        ],
    ]) ?>

    <h2>
        Project
    </h2>    

</div>
