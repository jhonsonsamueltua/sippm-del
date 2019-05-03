<?php
/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\ClassAssignment;
use common\models\StudentAssignment;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;

$this->title = $model->asg_title;
// $this->params['breadcrumbs'][] = ['label' => 'Assignments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="body-content">
    <div class=" container box-content">
        <h3> <b> Detail Penugasan </b> <font class="text-title"> <?= Html::encode($this->title) ?> </font> </h3>
        <hr class="hr-custom">

        <?php
            $button = "";
            
            if($model->sts_asg_id == 1 || $model->sts_asg_id == 3){
                $button = '<p>'. Html::a("Update", ["update", "id" => $model->asg_id], ["class" => "btn btn-primary"]) .' &nbsp; &nbsp;'.
                Html::a("Delete", ["delete", "id" => $model->asg_id], [
                    "class" => "btn btn-danger",
                    "data" => [
                        "confirm" => "Are you sure you want to delete this item?",
                        "method" => "post",
                    ],
                ]).'</p>';
            }

            $content1 = 
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['attribute' => 'asg_title',
                            'label' => 'Judul Penugasan'],
                        ['attribute' => 'asg_description',
                            'label' => 'Deskripsi Penugasan',
                            'format' => 'raw'],
                        ['attribute' => 'asg_start_time',
                            'label' => 'Batas Awal'],
                        ['attribute' => 'asg_end_time',
                            'label' => 'Batas Akhir'],
                        // ['attribute' => 'asg_year',
                        //     'label' => 'Tahun'],
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
                ]) . $button;

            $label2 = "Proyek [$countProject]";
            $tempContent2 = "";

            foreach($projects as $data){
                $tempContent2 = $tempContent2 . '
                <tr>
                    <td>'.$data->proj_creator.'</td>
                    <td>'.Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]).'</td>
                    <td>'.$data->proj_author.'</td>
                </tr>
                ';
            }

            $content2 = '
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Diunggah oleh</th>
                        <th>Proyek</th>
                        <th>Author</th>
                    </tr>
                    </thead>
                    <tbody>'
                        .$tempContent2.
                    '</tbody>
                </table>';

            echo Tabs::widget([
                'items' => [
                    [
                        'label' => 'Penugasan',
                        'content' => $content1,
                        'active' => true
                    ],
                    [
                        'label' => $label2,
                        'content' => $content2,
                    ],
                ],
            ]);
        ?>
    </div>
</div>