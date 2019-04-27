<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\httpclient\Client;
use common\models\Assignment;
use common\models\Student;
use common\models\Project;
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
    
    public function beforeAction($action){
        $this->layout = "main";

        return parent::beforeAction($action);
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

    public function actionManagemenProyek(){
        $session = Yii::$app->session;

        return $this->render('managemen-proyek',[

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
        $model = $this->findModel($id);
        $projects = Project::find()->where(['asg_id' => $id])->andWhere('deleted' != 1)->all();
        $countProject = Project::find()->where(['asg_id' => $id])->count();
        return $this->render('view', [
            'model' => $model,
            'projects' => $projects,
            'countProject' => $countProject,
        ]);
    }

    public function actionViewDetailAssignment($asg_id)
    {   
        $model = $this->findModel($asg_id);
        $modelProject = Project::find()->where(['asg_id' => $asg_id])->one();
        return $this->render('view-detail-assignment', [
            'model' => $model,
            'modelProject' => $modelProject,
        ]);
    }

    public function actionAssignmentStudent(){
        $this->openCloseAssignment();

        $session = Yii::$app->session;
        $username = $session['nim'];

        $saatIni = "SELECT * FROM sippm_assignment as sa JOIN sippm_class_assignment as sca ON sa.asg_id = sca.asg_id JOIN sippm_student_assignment as ssa ON sca.cls_asg_id = ssa.cls_asg_id WHERE ssa.stu_id = $username AND (sa.sts_asg_id = 1 OR sa.sts_asg_id = 3)";
        $modelPenugasanSaatIni = Yii::$app->db->createCommand($saatIni)->queryAll();
        $modelPenugasanSaatIniCount = count($modelPenugasanSaatIni);

        // $pagination = new Pagination(['totalCount' => $modelPenugasanSaatIniCount, 'pageSize' => 5]);
        
        $riwayat = "SELECT * FROM sippm_assignment as sa JOIN sippm_class_assignment as sca ON sa.asg_id = sca.asg_id JOIN sippm_student_assignment as ssa ON sca.cls_asg_id = ssa.cls_asg_id WHERE ssa.stu_id = $username AND sa.sts_asg_id = 2";
        $modelRiwayatPenugasan = Yii::$app->db->createCommand($riwayat)->queryAll();
        $modelRiwayatPenugasanCount = count($modelRiwayatPenugasan);

        // $pagination = new Pagination(['totalCount' => $modelRiwayatPenugasanCount, 'pageSize' => 1]);
        // $modelRiwayatPenugasan = $modelRiwayatPenugasan->offset($pagination->offset)
        // ->limit($pagination->limit)
        // ->all();

        return $this->render('assignment-student',[
            'modelPenugasanSaatIni' => $modelPenugasanSaatIni,
            'modelRiwayatPenugasan' => $modelRiwayatPenugasan,
            'modelPenugasanSaatIniCount' => $modelPenugasanSaatIniCount,
            'modelRiwayatPenugasanCount' => $modelRiwayatPenugasanCount,
        ]);
    }

    public function actionAssignmentDosen(){
        $session = Yii::$app->session;

        $this->openCloseAssignment();
        
        $modelPenugasanSaatIni = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['or', ['sts_asg_id' => 1], ['sts_asg_id' => 3]])->andWhere('deleted' != 1)->all();
        $modelRiwayatPenugasan = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 2])->andWhere('deleted' != 1)->all();

        $modelPenugasanSaatIniCount = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['or', ['sts_asg_id' => 1], ['sts_asg_id' => 3]])->andWhere('deleted' != 1)->count();
        $modelRiwayatPenugasanCount = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 2])->andWhere('deleted' != 1)->count();

        return $this->render('assignment-dosen',[
            'modelPenugasanSaatIni' => $modelPenugasanSaatIni,
            'modelRiwayatPenugasan' => $modelRiwayatPenugasan,
            'modelPenugasanSaatIniCount' => $modelPenugasanSaatIniCount,
            'modelRiwayatPenugasanCount' => $modelRiwayatPenugasanCount,
        ]);
    }

    public function openCloseAssignment(){
        $session = Yii::$app->session;
        //Bagian update status penugasan pending menjadi open
        date_default_timezone_set("Asia/Bangkok");
        $now = new \DateTime();
        $model = Assignment::find()->where(['sts_asg_id' => 3])->andWhere('deleted' != 1)->all();
        $modelCount = Assignment::find()->where(['sts_asg_id' => 3])->andWhere('deleted' != 1)->count();

        if($modelCount > 0){
            foreach($model as $data){
                $start = new \DateTime($data->asg_start_time);
                $end = new \DateTime($data->asg_end_time);
                if($now >= $start && $now <= $end){
                    $data->sts_asg_id = 1;
                    $data->save();
                }
            }
        }

        //bagian update status penugasan open menjadi close
        $model2 = Assignment::find()->where(['sts_asg_id' => 1])->andWhere('deleted' != 1)->all();
        $model2Count = Assignment::find()->where(['sts_asg_id' => 1])->andWhere('deleted' != 1)->count();

        if($model2Count > 0){
            foreach($model2 as $data){
                $end = new \DateTime($data->asg_end_time);
                if($now >= $end){
                    $data->sts_asg_id = 2;
                    $data->save();
                }
            }
        }
    }
    
    public function getStatusAssignment($asg_id){
        $model = $this->findModel($asg_id);
        $result = $model->stsAsg->sts_asg_name;
        return $result;
    }

    public function actionCreate()
    {   
        $session = Yii::$app->session;

        $modelAsg = new Assignment;
        
        $modelsClsAsg = [new ClassAssignment];

        $modelsStuAsg = [[new StudentAssignment]];

        if ($modelAsg->load(Yii::$app->request->post())) {
 
            $modelsClsAsg = Model::createMultiple(ClassAssignment::classname());
            Model::loadMultiple($modelsClsAsg, Yii::$app->request->post());
            
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
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $modelAsg->asg_creator = $session["nama"];
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
                                        $client = new Client();
                                        $response = $client->createRequest()
                                                            ->setMethod('GET')
                                                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-students-by-class?kelas_id=' . $modelClass->class)
                                                            ->send();

                                        if($response->isOk){
                                            if($response->data['result'] == "OK"){
                                                foreach($response->data['data'] as $student){
                                                    $studentModel = new StudentAssignment();
                                                    $studentModel->stu_id = $student['nim'];
                                                    $studentModel->cls_asg_id = $modelClass->cls_asg_id;
                                                    
                                                    $studentModel->save();
                                                }
                                            }
                                        }
                                    }
                                    // $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
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

        return $this->render('create', [
            'modelAsg' => $modelAsg,
            'modelsClsAsg' => (empty($modelsClsAsg)) ? [new ClassAssignment] : $modelsClsAsg,
            'modelsStuAsg' => (empty($modelsStuAsg)) ? [[new StudentAssignment]] : $modelsStuAsg,
        ]);
    }

    public function getAllClass(){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-class')
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                $listKelas = array();

                foreach($response->data['data'] as $kelas){
                    $listKelas += [$kelas['kelas_id'] => $kelas['nama']];
                }
            }
        }
        return $listKelas;
    }
    public function actionLists($id){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-students-by-class?kelas_id=' . $id)
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                $students = array();

                foreach($response->data['data'] as $student){
                    array_push($students, [$student['nim'], $student['nama']]);
                }
            }
        }

        $countStudents = count($students);

        echo "<option value=''>Pilih Mahasiswaa ..</option>";
        if($countStudents > 0){
            foreach($students as $student){
                echo "<option value='". $student[0] ."'>". $student[1] ."</option>";
            }
        }
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
            $modelsClsAsg = Model::createMultiple(ClassAssignment::classname());
            // $modelsClsAsg = Model::createMultiple(ClassAssignment::classname(), $modelsClsAsg);
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
                                        $client = new Client();
                                        $response = $client->createRequest()
                                                            ->setMethod('GET')
                                                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-students-by-class?kelas_id=' . $modelClass->class)
                                                            ->send();

                                        if($response->isOk){
                                            if($response->data['result'] == "OK"){
                                                foreach($response->data['data'] as $student){
                                                    $studentModel = new StudentAssignment();
                                                    $studentModel->stu_id = $student['nim'];
                                                    $studentModel->cls_asg_id = $modelClass->cls_asg_id;
                                                    
                                                    $studentModel->save();
                                                }
                                            }
                                        }
                                    }
                                    // $modelStudent->cls_asg_id = $modelClass->cls_asg_id;
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

    public function getProject($id){
        $session = Yii::$app->session;
        $model = Project::find()->where(['asg_id' => $id, 'created_by' => $session["username"]])->one();
        // echo '<pre>';
        // var_dump($model);
        // die();
        return isset($model) ? $model : false ;

    }

    /**
     * Deletes an existing Assignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $this->findModel($id)->softDelete();

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
