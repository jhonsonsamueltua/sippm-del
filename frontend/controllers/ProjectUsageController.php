<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use common\models\Project;
use common\models\ProjectUsage;
use common\models\search\ProjectUsageSearch;
use common\models\StatusProjectUsage;
use common\models\CategoryUsage;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    // public function beforeAction($action){
    //     $this->layout = "main-2";

    //     return parent::beforeAction($action);
    // }

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

            $pagination = new Pagination(['totalCount' => $modelRequestCount, 'pageSize' => 5]);
            // $pagination2 = new Pagination(['totalCount' => $modelRiwayatCount, 'pageSize' => 5]);
            $modelRequest = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['sts_proj_usg_id' => 1])->andWhere('deleted!=1')->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
            $modelRiwayat = ProjectUsage::find()->Where(['created_by' => $session['username']])->andWhere(['or',['sts_proj_usg_id' => 2], ['sts_proj_usg_id' => 3]])->andWhere('deleted!=1')->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

            $query = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND PU.sts_proj_usg_id = 1';
            $modelRequestUsers = Yii::$app->db->createCommand($query)->queryAll();
            $modelRequestUsersCount = count($modelRequestUsers);

            $query2 = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1 AND (PU.sts_proj_usg_id = 2 OR PU.sts_proj_usg_id = 3)';
            $modelRiwayatRequestOrangLain = Yii::$app->db->createCommand($query2)->queryAll();
            $modelRiwayatRequestOrangLainCount = count($modelRiwayatRequestOrangLain);

            return $this->render('index', [
                'modelRequest' => $modelRequest,
                'modelRequestUsers' => $modelRequestUsers,
                'modelRiwayat' => $modelRiwayat,
                'modelRiwayatRequestOrangLain' => $modelRiwayatRequestOrangLain,
                'modelRequestCount' => $modelRequestCount,
                'modelRequestUsersCount' => $modelRequestUsersCount,
                'modelRiwayatCount' => $modelRiwayatCount,
                'modelRiwayatRequestOrangLainCount' => $modelRiwayatRequestOrangLainCount,
                'pagination' => $pagination,
                // 'pagination2' => $pagination2,
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

    public function getProject($proj_id){
        $session = Yii::$app->session;
        $model = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted' != 1)->one();

        return $model;
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

            if ($model->load(Yii::$app->request->post())){
                $model->proj_id = $proj_id;
                $model->sts_proj_usg_id = 1;
                $model->user_email = $session['email'];
                $model->proj_usg_creator = $session['nama'];
            
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->proj_usg_id]);
                }else{
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
            $this->sendEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['list-project-usage-request']);
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
            $this->sendEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['list-project-usage-request']);
        }
    }

    private function sendEmail($to, $status, $proj_id){
        $project = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one();
        $link = "localhost/sippm-del/index.php?r=project/view-project";

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

}
