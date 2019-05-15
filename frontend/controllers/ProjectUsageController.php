<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use common\models\Assignment;
use common\models\Project;
use common\models\ProjectUsage;
use common\models\search\ProjectUsageSearch;
use common\models\StatusProjectUsage;
use common\models\CategoryUsage;

/**
 * ProjectUsageController implements the CRUD actions for ProjectUsage model.
 */
class ProjectUsageController extends Controller
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
     * Lists all ProjectUsage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $modelRequestCount = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['sts_proj_usg_id' => 1])->andWhere('deleted!=1')->count();
            $modelRiwayatCount = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['or',['sts_proj_usg_id' => 2], ['sts_proj_usg_id' => 3]])->andWhere('deleted!=1')->count();

            $modelRequest = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['sts_proj_usg_id' => 1])->andWhere('deleted!=1')->orderBy('created_at DESC')->all();
            $modelRiwayat = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['or',['sts_proj_usg_id' => 2], ['sts_proj_usg_id' => 3]])->andWhere('deleted!=1')->orderBy('created_at DESC')->all();

            $query = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, PU.created_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND PU.sts_proj_usg_id = 1 AND PU.alternate != 1 ORDER BY PU.created_at DESC';
            $modelRequestUsers = Yii::$app->db->createCommand($query)->queryAll();
            $modelRequestUsersCount = count($modelRequestUsers);

            $query2 = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, PU.created_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND (PU.sts_proj_usg_id = 2 OR PU.sts_proj_usg_id = 3) AND PU.alternate != 1 ORDER BY PU.created_at DESC';
            $modelRiwayatRequestUsers = Yii::$app->db->createCommand($query2)->queryAll();
            $modelRiwayatRequestUsersCount = count($modelRiwayatRequestUsers);

            return $this->render('index', [
                'modelRequest' => $modelRequest,
                'modelRequestUsers' => $modelRequestUsers,
                'modelRiwayat' => $modelRiwayat,
                'modelRiwayatRequestUsers' => $modelRiwayatRequestUsers,
                'modelRequestCount' => $modelRequestCount,
                'modelRequestUsersCount' => $modelRequestUsersCount,
                'modelRiwayatCount' => $modelRiwayatCount,
                'modelRiwayatRequestUsersCount' => $modelRiwayatRequestUsersCount,
            ]);
        }
    }

    public function actionView($id)
    {   
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionListProjectUsageRequest(){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == 'Mahasiswa'){
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->goHome();
        }else{
            $query = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND PU.sts_proj_usg_id = 1';
            $modelRequest = Yii::$app->db->createCommand($query)->queryAll();
            $modelRequestCount = count($modelRequest);

            $query2 = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND (PU.sts_proj_usg_id = 2 OR PU.sts_proj_usg_id = 3)';
            $modelRiwayat = Yii::$app->db->createCommand($query2)->queryAll();
            $modelRiwayatCount = count($modelRiwayat);

            return $this->render('list-project-usage-request', [
                'modelRequest' => $modelRequest,
                'modelRiwayat' => $modelRiwayat,
                'modelRequestCount' => $modelRequestCount,
                'modelRiwayatCount' => $modelRiwayatCount,
            ]);
        }
    }

    public function getCategoryPenggunaan($id){
        $model = CategoryUsage::find()->where(['cat_usg_id' => $id])->one();
        $category = $model->cat_usg_name;
        
        return $model->cat_usg_name;
    }

    /**
     * Creates a new ProjectUsage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($proj_id){
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = new ProjectUsage();
            $projModel = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one();
            $asgModel = Assignment::find()->where(['asg_id' => $projModel->asg_id])->andWhere('deleted!=1')->one();

            if ($model->load(Yii::$app->request->post())){
                $coordinatorStat = $this->checkDosenActiveStatus($asgModel->asg_creator_id);

                $model->proj_id = $proj_id;
                $model->sts_proj_usg_id = 1;
                $model->user_email = $session['email'];
                $model->proj_usg_creator = $session['nama'];
                
                if($coordinatorStat == "Tidak Aktif"){
                    $model->alternate = 1;
                }

                if($model->save()){
                    if($coordinatorStat == "Aktif"){
                        $this->sendRequestEmail($asgModel->asg_creator_email, $proj_id, $session['nama']);
                    }else{
                        $this->sendRequestEmail($asgModel->asg_alternate_email, $proj_id, $session['nama']);
                    }
                    Yii::$app->session->setFlash('success', '<center> Permohonan anda berhasil dikirim. Untuk tindak lanjut akan di kirim melalui email.</center>');
                    return $this->redirect(['view', 'id' => $model->proj_usg_id]);
                }else{
                    Yii::$app->session->setFlash('error', 'Maaf, terjadi kesalahan pada saat permohonan penggunaan proyek. Silahkan melakukan permohonan ulang atau menghubungi penyedia layanan.');

                    return $this->redirect('create', [
                        'model' => $model,
                    ]);
                }
            }

            if($this->findProject($proj_id) != null){
                return $this->render('create', [
                    'model' => $model,
                    'project' => $this->getProject($proj_id),
                ]);
            }
        }
    }

    /**
     * Updates an existing ProjectUsage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($proj_usg_id)
    {
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = $this->findModel($proj_usg_id);

            if($model->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Maaf, anda tidak mempunyai hak untuk memodifikasi permohonan penggunaan ini.'); 

                return $this->redirect(['/']);
            }else{
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['index']);
                }
                
                return $this->render('update', [
                    'model' => $model,
                    'project' => $this->getProject($model->proj_id),
                ]);
            }
        }
    }

    /**
     * Deletes an existing ProjectUsage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCancel($proj_usg_id)
    {
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = $this->findModel($proj_usg_id);

            if($model->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Maaf, anda tidak mempunyai hak untuk memodifikasi permohonan penggunaan ini.'); 

                return $this->redirect(['/']);
            }else{
                $model->softDelete();
                
                return $this->redirect(['index']);
            }
        }
    }

    public function actionAcceptRequest($proj_usg_id){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role' == 'Mahasiswa']){
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman ini');
            
            return $this->goHome();
        }else{
            $request = ProjectUsage::find()->where(['proj_usg_id' => $proj_usg_id])->andWhere('deleted!=1')->one();

            $request->sts_proj_usg_id = 2;
            $request->save();

            $status = $this->getProjectRequestStatus($request->sts_proj_usg_id);
            $this->sendResponseEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['index']);
        }
    }

    public function actionRejectRequest($proj_usg_id){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role' == 'Mahasiswa']){
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman ini');
            
            return $this->goHome();
        }else{
            $request = ProjectUsage::find()->where(['proj_usg_id' => $proj_usg_id])->andWhere('deleted!=1')->one();

            $request->sts_proj_usg_id = 3;
            $request->save();

            $status = $this->getProjectRequestStatus($request->sts_proj_usg_id);
            $this->sendResponseEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['list-project-usage-request']);
        }
    }

    private function sendRequestEmail($to, $proj_id, $requester){
        $project = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one();
        $link = "/localhost/sippm-del/index.php?r=project-usage/list-project-usage-request";
        $emailBody = "$requester telah melakukan permohonan penggunaan untuk proyek $project->proj_title. Silahkan klik link berikut untuk menindaklanjuti permohonan penggunaan ini.<br>". Html::a($project->proj_title, [$link]);

        Yii::$app->mailer->compose()
            ->setFrom('sippm.del@gmail.com')
            ->setTo($to)
            ->setSubject('[SIPPM] Permohonan Penggunaan Proyek')
            ->setHtmlBody($emailBody)
            ->send();
    }

    private function sendResponseEmail($to, $status, $proj_id){
        $project = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one();
        $link = "/localhost/sippm-del/index.php?r=project/view-project";

        if($status == "Diterima")
            $emailBody = "Request penggunaan anda untuk proyek $project->proj_title telah $status. Silahkan klik link berikut untuk melakukan pengunduhan file proyek.<br>". Html::a($project->proj_title, [$link, 'proj_id' => $project->proj_id]);
        else
            $emailBody = "Request penggunaan anda untuk proyek $project->proj_title telah $status. Silahkan klik link berikut untuk <i>request</i> ulang file proyek.<br>". Html::a($project->proj_title, [$link, 'proj_id' => $project->proj_id]);

        Yii::$app->mailer->compose()
            ->setFrom('sippm.del@gmail.com')
            ->setTo($to)
            ->setSubject('[SIPPM] Permohonan Penggunaan Proyek')
            ->setHtmlBody($emailBody)
            ->send();
    }

    public static function getProjectRequestStatus($sts_id){
        $status = StatusProjectUsage::find()->where(['sts_proj_usg_id' => $sts_id])->andWhere('deleted!=1')->one();
    
        return $status->sts_proj_usg_name;
    }
    
    /**
     * Finds the ProjectUsage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectUsage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectUsage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function findProject($proj_id){
        if(($model = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one() != null)){
            return $model;
        }

        throw new NotFoundHttpException('Proyek yang dimaksud tidak ada atau telah dihapus.');
    }

    public function getProject($proj_id){
        $session = Yii::$app->session;
        $model = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted' != 1)->one();

        return $model;
    }

    private function checkDosenActiveStatus($pegawai_id){
        $client = new Client();
        $response = $client->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://cis.del.ac.id/api/sippm-api/get-dosen-active-status?pegawai_id=' . $pegawai_id)
                            ->send();

        if($response->isOk){
            if($response->data['result'] == "OK"){
                return $response->data['data'];
            }
        }
    }

}
