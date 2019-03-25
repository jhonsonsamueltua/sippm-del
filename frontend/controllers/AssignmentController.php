<?php

namespace frontend\controllers;

use Yii;
use common\models\Assignment;
use common\models\ClassAssignment;
use common\models\StudentAssignment;
use common\models\search\AssignmentSearch;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\SippmClass;


/**
 * AssignmentController implements the CRUD actions for Assignment model.
 */
class AssignmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $modelClass = ClassAssignment::find()->where(['asg_id' => $id])->all();
        // $modelStudent = StudentAssignment::find()->where(['asg_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Assignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateBackup()
    {
        $model = new Assignment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->asg_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {   
        $modelAsg = new Assignment;
        
        $modelsClsAsg = [new ClassAssignment];

        $modelsStuAsg = [[new StudentAssignment]];

        if ($modelAsg->load(Yii::$app->request->post())) {
            
            $modelsClsAsg = Model::createMultiple(ClassAssignment::classname());
            Model::loadMultiple($modelsClsAsg, Yii::$app->request->post());
            
            // validate person and houses models
            $valid = $modelAsg->validate();
            // $valid = Model::validateMultiple($modelsClsAsg) && $valid;
            
            if (isset($_POST['StudentAssignment'][0][0])) { 
                foreach ($_POST['StudentAssignment'] as $indexClass => $students) {
                    foreach ($students as $indexStudent => $student) {
                        $data['StudentAssignment'] = $student;
                        $modelStuAsg = new StudentAssignment;
                        $modelStuAsg->load($data);
                        $modelsStuAsg[$indexClass][$indexStudent] = $modelStuAsg;
                        $valid = $modelStuAsg->validate();
                    }
                }
            }else{
                die($valid);
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelAsg->save(false)) {
                        foreach ($modelsClsAsg as $indexClass => $modelClass) {

                            if ($flag === false) {
                                break;
                            }

                            $modelClass->asg_id = $modelAsg->asg_id;

                            if (!($flag = $modelClass->save(false))) {
                                break;
                            }

                            if (isset($modelsStuAsg[$indexClass]) && is_array($modelsStuAsg[$indexClass])) {
                                foreach ($modelsStuAsg[$indexClass] as $indexStudent => $modelStudent) {
                                    if($modelStudent->stu_id == ''){   
                                        //Tempat insert semua mahasiswa by kelas. (Jika mahasiswa tidak ada yang dibuat) 
                                        // die("Insert data Mahasiswa by Kelas ".$modelClass->class);
                                        $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
                                        $modelStudent->stu_id = 3;
                                    }else{
                                        $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
                                    }
                                    
                                    if (!($flag = $modelStudent->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelAsg->asg_id]);
                    } else {
                        die("Gagal Insert");
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    die("Tidak Valid");
                    $transaction->rollBack();
                }
            }
        }


        return $this->render('create', [
            'modelAsg' => $modelAsg,
            'modelsClsAsg' => (empty($modelsClsAsg)) ? [new ClassAssignment] : $modelsClsAsg,
            'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new StudentAssignment]] : $modelsStuAsg,
        ]);
    }

    /**
     * Updates an existing Assignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelAsg = $this->findModel($id);
        $modelsClsAsg = $modelAsg->classes;
        $modelsStuAsg = [];
        $oldStudents = [];

        if (!empty($modelsClsAsg)) {
            foreach ($modelsClsAsg as $indexClass => $modelClass) {
                $students = $modelClass->students;
                $modelsStuAsg[$indexClass] = $students;
                $oldStudents = ArrayHelper::merge(ArrayHelper::index($students, 'stu_asg_id'), $oldStudents);
            }
        }

        if ($modelAsg->load(Yii::$app->request->post())) {

            // reset
            $modelsStuAsg = [];
            
            $oldClassIDs = ArrayHelper::map($modelsClsAsg, 'cls_asg_id', 'cls_asg_id');
            // $modelsClsAsg = Model::createMultiple(ClassAssignment::classname());
            $modelsClsAsg = Model::createMultiple(ClassAssignment::classname(), $modelsClsAsg);
            Model::loadMultiple($modelsClsAsg, Yii::$app->request->post());
            $deletedClassIDs = array_diff($oldClassIDs, array_filter(ArrayHelper::map($modelsClsAsg, 'cls_asg_id', 'cls_asg_id')));
            
            // validate person and houses models
            $valid = $modelAsg->validate();
            $valid = Model::validateMultiple($modelsClsAsg) && $valid;
            
            $studentsIDs = [];
            if (isset($_POST['StudentAssignment'][0][0])) {
                foreach ($_POST['StudentAssignment'] as $indexClass => $students) {
                    $studentsIDs = ArrayHelper::merge($studentsIDs, array_filter(ArrayHelper::getColumn($students, 'stu_id')));
                    foreach ($students as $indexStudent => $student) {
                        $data['StudentAssignment'] = $student;
                        $modelStudent = (isset($student['stu_asg_id']) && isset($oldStudents[$student['stu_asg_id']])) ? $oldStudents[$student['stu_asg_id']] : new StudentAssignment;
                        $modelStudent->load($data);
                        $modelsStuAsg[$indexClass][$indexStudent] = $modelStudent;
                        $valid = $modelStudent->validate();
                    }
                }
            }

            //LANJUT DISINI BRAYYYYYYY
            $oldStudentsIDs = ArrayHelper::getColumn($oldStudents, 'stu_asg_id');
            $deletedStudentsIDs = array_diff($oldStudentsIDs, $studentsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelAsg->save(false)) {

                        if (! empty($deletedStudentsIDs)) {
                            StudentAssignment::deleteAll(['stu_asg_id' => $deletedStudentsIDs]);
                        }

                        if (! empty($deletedClassIDs)) {
                            ClassAssignment::deleteAll(['cls_asg_id' => $deletedClassIDs]);
                        }

                        foreach ($modelsClsAsg as $indexClass => $modelClass) {

                            if ($flag === false) {
                                break;
                            }

                            $modelClass->asg_id = $modelAsg->asg_id;

                            if (!($flag = $modelClass->save(false))) {
                                break;
                            }

                            if (isset($modelsStuAsg[$indexClass]) && is_array($modelsStuAsg[$indexClass])) {
                                foreach ($modelsStuAsg[$indexClass] as $indexStudent => $modelStudent) {

                                    if($modelStudent->stu_id == ''){   
                                        //Tempat insert semua mahasiswa by kelas. (Jika mahasiswa tidak ada yang dibuat) 
                                        // die("Insert data Mahasiswa by Kelas ".$modelClass->class);
                                        $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
                                        $modelStudent->stu_id = 3;
                                    }else{
                                        $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
                                    }
                                    
                                    if (!($flag = $modelStudent->save(false))) {
                                        break;
                                    }


                                    // $modelStudent->cls_asg_id = $modelHouse->cls_asg_id;
                                    // if (!($flag = $modelStudent->save(false))) {
                                    //     break;
                                    // }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelAsg->asg_id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelAsg' => $modelAsg,
            'modelsClsAsg' => (empty($modelsClsAsg)) ? [new House] : $modelsClsAsg,
            'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new Room]] : $modelsStuAsg
        ]);
    }

    /**
     * Deletes an existing Assignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
