<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\httpclient\Client;
use common\controllers\NotificationController;
use common\models\Assignment;
use common\models\CategoryProject;
use common\models\SubCategoryProject;
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
use yii\helpers\Json;
use backend\models\SippmClass;
use common\controllers\NotificationViewerController;


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
     * Displays a single Assignment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        $projects = Project::find()->where(['asg_id' => $id])->andWhere('deleted' != 1)->all();

        return $this->render('view', [
            'model' => $model,
            'projects' => $projects,
            'projectsCount' => count($projects),
        ]);
    }

    public function actionAssignmentStudent($ntf_id = ''){
        $this->openCloseAssignment();

        $session = Yii::$app->session;
        $class = $session['kelas_id'];

        if($ntf_id != ''){
            NotificationViewerController::createNotificationViewer($ntf_id, $session['username']);
        }

        $saatIni = "SELECT * FROM sippm_assignment as sa JOIN sippm_class_assignment as sca ON sa.asg_id = sca.asg_id JOIN sippm_category_project as scp ON sa.cat_proj_id = scp.cat_proj_id JOIN sippm_sub_category_project as sscp ON sa.sub_cat_proj_id = sscp.sub_cat_proj_id WHERE sca.class = '$class' AND sa.sts_asg_id = 1 GROUP BY sa.asg_title ORDER BY sa.asg_start_time ASC";
        $modelPenugasanSaatIni = Yii::$app->db->createCommand($saatIni)->queryAll();
        $modelPenugasanSaatIniCount = count($modelPenugasanSaatIni);

        $menunggu = "SELECT * FROM sippm_assignment as sa JOIN sippm_class_assignment as sca ON sa.asg_id = sca.asg_id JOIN sippm_category_project as scp ON sa.cat_proj_id = scp.cat_proj_id JOIN sippm_sub_category_project as sscp ON sa.sub_cat_proj_id = sscp.sub_cat_proj_id WHERE sca.class = '$class' AND sa.sts_asg_id = 3 GROUP BY sa.asg_title ORDER BY sa.asg_start_time ASC";
        $modelMenunggu = Yii::$app->db->createCommand($menunggu)->queryAll();
        $modelMenungguCount = count($modelMenunggu);

        
        $riwayat = "SELECT * FROM sippm_assignment as sa JOIN sippm_class_assignment as sca ON sa.asg_id = sca.asg_id JOIN sippm_category_project as scp ON sa.cat_proj_id = scp.cat_proj_id JOIN sippm_sub_category_project as sscp ON sa.sub_cat_proj_id = sscp.sub_cat_proj_id WHERE sca.class = '$class' AND sa.sts_asg_id = 2 GROUP BY sa.asg_title ORDER BY sa.asg_start_time ASC";
        $modelRiwayatPenugasan = Yii::$app->db->createCommand($riwayat)->queryAll();
        $modelRiwayatPenugasanCount = count($modelRiwayatPenugasan);
        
        return $this->render('assignment-student',[
            'modelPenugasanSaatIni' => $modelPenugasanSaatIni,
            'modelRiwayatPenugasan' => $modelRiwayatPenugasan,
            'modelMenunggu' => $modelMenunggu,
            'modelPenugasanSaatIniCount' => $modelPenugasanSaatIniCount,
            'modelRiwayatPenugasanCount' => $modelRiwayatPenugasanCount,
            'modelMenungguCount' => $modelMenungguCount,
        ]);
    }

    public function actionAssignmentDosen(){
        $session = Yii::$app->session;

        $this->openCloseAssignment();

        $modelPenugasanSaatIni = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 1])->andWhere('deleted != 1')->orderBy('created_at DESC')->all();
        $modelPenugasanSaatIniCount = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 1])->andWhere('deleted != 1')->count();
        // die($modelPenugasanSaatIniCount);
        $modelRiwayatPenugasan = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 2])->andWhere('deleted != 1')->orderBy('created_at DESC')->all();
        $modelRiwayatPenugasanCount = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 2])->andWhere('deleted != 1')->count();
        
        $modelMenunggu = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 3])->andWhere('deleted != 1')->orderBy('created_at DESC')->all();
        $modelMenungguCount = Assignment::find()->where(['created_by' => $session['username']])->andWhere(['sts_asg_id' => 3])->andWhere('deleted != 1')->count();

        return $this->render('assignment-dosen',[
            'modelPenugasanSaatIni' => $modelPenugasanSaatIni,
            'modelRiwayatPenugasan' => $modelRiwayatPenugasan,
            'modelMenunggu' => $modelMenunggu,
            'modelPenugasanSaatIniCount' => $modelPenugasanSaatIniCount,
            'modelRiwayatPenugasanCount' => $modelRiwayatPenugasanCount,
            'modelMenungguCount' => $modelMenungguCount,
        ]);
    }

    /**
     * CRUD
     */

    public function actionCreate()
    {   
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == "Mahasiswa"){
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->redirect(['site/index']);
        }else{
            $modelAsg = new Assignment();
            
            if($modelAsg->load(Yii::$app->request->post())){
                $transaction = Yii::$app->db->beginTransaction();
                
                try{
                    $modelAsg->asg_creator_id = $session['pegawaiId'];
                    $modelAsg->asg_creator = $session['nama'];
                    $modelAsg->asg_creator_email = $session['email'];

                    // open or pending assignment
                    date_default_timezone_set("Asia/Bangkok");
                    $now = new \DateTime();
                    $start = new \DateTime($modelAsg->asg_start_time);
                    $end = new \DateTime($modelAsg->asg_end_time);
                    
                    if($now >= $start && $now <= $end){
                        $modelAsg->sts_asg_id = 1;
                    }
    
                    $innerTransaction = Yii::$app->db->beginTransaction();

                    try{
                        if(isset($_POST['allClass'])){
                            $modelAsg->class = "All";
                            $modelAsg->save();

                            $client = new Client();
                            $response = $client->createRequest()
                                                    ->setMethod('GET')
                                                    ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-class')
                                                    ->send();

                            if($response->isOk){
                                if($response->data['result'] == "OK"){
                                    $modelClass = new ClassAssignment();

                                    foreach($response->data['data'] as $class){
                                        $modelClass->setIsNewRecord(true);
                                        $modelClass->class = (string) $class['kelas_id'];
                                        $modelClass->asg_id = $modelAsg->asg_id;
                                        $modelClass->partial = 0;
                                        $modelClass->save();
                                        $modelClass->cls_asg_id++;

                                        NotificationController::sendAssignmentNotification('assignment', $modelAsg->asg_id, $class['kelas_id']);
                                    }
                                }
                            }
                        }else{
                            $modelAsg->class = "Partial";
                            $modelAsg->save();

                            $modelClass = new ClassAssignment();
                            foreach($_POST['Class'] as $i => $class){
                                $modelClass->setIsNewRecord(true);
                                $modelClass->class = $class;
                                $modelClass->asg_id = $modelAsg->asg_id;
                                $modelClass->partial = 0;
                                $modelClass->save();
                                $modelClass->cls_asg_id++;

                                NotificationController::sendAssignmentNotification('assignment', $modelAsg->asg_id, $class);
                            }
                        }

                        $innerTransaction->commit();
                    }catch(Exception $e){
                        Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuka penugasan.');

                        $innerTransaction->rollback();
                        
                        throw $e;
                    }
                    
                    $transaction->commit();
    
                    return $this->redirect(['view', 'id' => $modelAsg->asg_id]);
                }catch(Exception $e){
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuka penugasan.');
    
                    $transaction->rollBack();
                }
            }
    
            return $this->render('create', [
                'modelAsg' => $modelAsg,
            ]);
        }
    }

    public function actionUpdate($id)
    {   
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == "Mahasiswa"){
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->redirect(['site/index']);
        }else{
            $modelAsg = $this->findModel($id);

            if($modelAsg->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Anda tidak mempunyai hak untuk memodifikasi penugasan tersebut.'); 

                return $this->redirect(['assignment/assignment-dosen']);
            }else{
                $modelClass = ClassAssignment::find()->where(['asg_id' => $id])->andWhere('deleted != 1')->all();

                if($modelAsg->load(Yii::$app->request->post())){
                    $transaction = Yii::$app->db->beginTransaction();
                    
                    try{
                        $innerTransaction = Yii::$app->db->beginTransaction();

                        try{
                            if(isset($_POST['allClass'])){
                                $modelAsg->class = "All";
                                $modelAsg->save(false);

                                $client = new Client();
                                $response = $client->createRequest()
                                                        ->setMethod('GET')
                                                        ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-class')
                                                        ->send();

                                if($response->isOk){
                                    if($response->data['result'] == "OK"){
                                        $modelClass = new ClassAssignment();

                                        foreach($response->data['data'] as $class){
                                            $checkClass = ClassAssignment::find()->where(["class" => $class])->andWhere(["asg_id" => $modelAsg->asg_id])->andWhere('deleted != 1')->one();
                                            
                                            if($checkClass == null){
                                                $modelClass->setIsNewRecord(true);
                                                $modelClass->class = (string) $class['kelas_id'];
                                                $modelClass->asg_id = $modelAsg->asg_id;
                                                $modelClass->partial = 0;
                                                $modelClass->save();
                                                $modelClass->cls_asg_id++;
                                            
                                                NotificationController::sendAssignmentNotification('assignment', $modelAsg->asg_id, $class['kelas_id']);
                                            }
                                        }
                                    }
                                }
                            }else{
                                $modelAsg->save(false);

                                $modelClass = new ClassAssignment();

                                foreach($_POST['Class'] as $i => $class){
                                    $checkClass = ClassAssignment::find()->where(["class" => $class])->andWhere(["asg_id" => $modelAsg->asg_id])->andWhere('deleted != 1')->one();
        
                                    if($checkClass == null){
                                        $modelClass->setIsNewRecord(true);
                                        $modelClass->class = $class;
                                        $modelClass->asg_id = $modelAsg->asg_id;
                                        $modelClass->partial = 0;
                                        $modelClass->save();
                                        $modelClass->cls_asg_id++;

                                        NotificationController::sendAssignmentNotification('assignment', $modelAsg->asg_id, $class['kelas_id']);
                                    }
                                }
                            }

                            $innerTransaction->commit();
                        }catch(Exception $e){
                            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat mengubah penugasan.');

                            $innerTransaction->rollBack();

                            throw $e;
                        }

                        $transaction->commit();

                        return $this->redirect(['view', 'id' => $modelAsg->asg_id]);
                    }catch(Exception $e){
                        Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat mengubah penugasan.');

                        $transaction->rollBack();
                    }
                }

                return $this->render('update', [
                    'modelAsg' => $modelAsg,
                    'modelClass' => $modelClass,    
                ]);
            }
        }
    }

    /**
     * Deletes an existing Assignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == "Mahasiswa"){
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->redirect(['site/index']);
        }else{
            $modelAsg = $this->findModel($id);

            if($modelAsg->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Anda tidak mempunyai hak untuk memodifikasi penugasan tersebut.'); 

                return $this->redirect(['assignment/assignment-dosen']);
            }else{
                $modelClass = ClassAssignment::find()->where(['asg_id' => $modelAsg->asg_id])->andWhere('deleted!=1')->all();
                $modelProject = Project::find()->where(['asg_id' => $modelAsg->asg_id])->andWhere('deleted!=1')->all();

                foreach($modelClass as $class){
                    $class->softDelete();
                }

                foreach($modelProject as $project){
                    $project->softDelete();
                }

                $modelAsg->softDelete();

                return $this->redirect(['assignment-dosen']);
            }
        }
    }

    /**
     * Open / Close Assignment Method
     */

    public function actionOpenAssignment($asg_id){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == "Mahasiswa"){
            Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->redirect(['site/index']);
        }else{
            $modelAsg = $this->findModel($asg_id);
            
            if($modelAsg->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Anda tidak mempunyai hak untuk memodifikasi penugasan tersebut.'); 

                return $this->redirect(['assignment/assignment-dosen']);
            }else{
                if($modelAsg->load(Yii::$app->request->post())){
                    $modelAsg->sts_asg_id = 1;
                    $modelAsg->asg_end_time = $modelAsg->updated_end_time;
                    
                    if(!$modelAsg->save(false)){
                        Yii::$app->session->setFlash('danger', '<center>Terjadi kesalahan saat mengubah batas akhir penugasan</center>');
                    }else{
                        Yii::$app->session->setFlash('success', '<center>Berhasil membuka penugasan kembali.</center>');
                    }

                    return $this->redirect(['assignment-dosen']);
                }
            }
        }
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
                // $now->format('Y-m-d h:i:s')
                $start = new \DateTime($data->asg_start_time);
                $end = new \DateTime($data->asg_end_time);
                if($now > $start){
                    $data->sts_asg_id = 1;
                    $data->save(false);
                }
            }
        }

        //bagian update status penugasan open menjadi close
        $model2 = Assignment::find()->where(['sts_asg_id' => 1])->andWhere('deleted' != 1)->all();
        $model2Count = Assignment::find()->where(['sts_asg_id' => 1])->andWhere('deleted' != 1)->count();
        
        if($model2Count > 0){
            foreach($model2 as $data){
                $end = new \DateTime($data->asg_end_time);
                if($now > $end){
                    $data->sts_asg_id = 2;
                    $data->save(false);
                }
            }
        }
    }

    /**
     * Remove Class
     */

    public function actionRemoveClass($asg_id, $cls_asg_id){
        $class = ClassAssignment::find()->where(['cls_asg_id' => $cls_asg_id])->andWhere('deleted!=1')->one();

        $class->softDelete();

        return $this->redirect(['update', 'id' => $asg_id]);
    }

    /**
     * Getter
     */

    public function actionGetAllClass(){
        $session = Yii::$app->session;

        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-class')
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                $listKelas = array();

                foreach($response->data['data'] as $kelas){
                    array_push($listKelas, array('kelas_id' => $kelas['kelas_id'], 'nama' => $kelas['nama']));
                }
            }
        }

        echo Json::encode($listKelas);
    }

    public function getClassByClassId($id){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-class-by-class-id?kelas_id=' . $id)
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                foreach($response->data['data'] as $class){
                    $kelas = array();
                    array_push($kelas, array('nama' => $response->data['data']['nama'], 'ket' => $response->data['data']['ket']));
                }
            }
        }
        return $kelas;
    }

    public function actionGetAllStudents($kelas_id){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-all-students-by-class?kelas_id=' . $kelas_id)
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                $students = array();

                foreach($response->data['data'] as $student){
                    array_push($students, array('nim' => $student['nim'], 'nama' => $student['nama']));
                }
            }
        }
    
        echo Json::encode($students);
    }

    public function getStudentByNim($id){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-student-by-nim?nim=' . $id)
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                foreach($response->data['data'] as $student){
                    $name_student = $response->data['data']['nama'];
                }
            }
        }
        return $name_student;
    }

    public function getStatusAssignment($asg_id){
        $model = $this->findModel($asg_id);
        $result = $model->stsAsg->sts_asg_name;
        return $result;
    }

    public function getProject($id){
        $session = Yii::$app->session;
        $model = Project::find()->where(['asg_id' => $id])->andWhere(['created_by' => $session['username']])->andWhere('deleted!=1')->one();

        return isset($model) ? $model : false ;
    }

    /**
     * Find Method
     */

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Assignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Other Method
     */

    public function actionLists($id){
        $cat = CategoryProject::find()->where(['cat_proj_id' => $id])->andWhere('deleted != 1')->one();
        $model = SubCategoryProject::find()->where(['cat_proj_id' => $id])->andWhere('deleted != 1')->orderBy('sub_cat_proj_name ASC')->all();
        
        echo "<option value=''>Pilih ".$cat->cat_proj_name." ...</option>";
        
        if(count($model) > 0){
            foreach($model as $data){
                echo "<option value='". $data->sub_cat_proj_id ."'>". $data->sub_cat_proj_name ."</option>";
            }
        }
    }

}
