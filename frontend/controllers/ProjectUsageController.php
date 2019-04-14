<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectUsage;
use common\models\search\ProjectUsageSearch;
use common\models\StatusProjectUsage;
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

    public function beforeAction($action){
        $this->layout = "main-2";

        return parent::beforeAction($action);
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
            $requests = ProjectUsage::find()->Where(['created_by' => $session['nama']])->andWhere('deleted!=1')->all();

            return $this->render('index', [
                'requests' => $requests,
            ]);
        }
    }

    public function actionListProjectUsageRequest(){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else if($session['role'] == 'Mahasiswa'){
            Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman tersebut.');
            
            return $this->goHome();
        }else{
            $query = 'SELECT PU.proj_usg_id, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.proj_id, PU.created_by, P.proj_title FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE A.created_by = "'. $session["username"] .'" AND PU.deleted != 1';
            $model = Yii::$app->db->createCommand($query)->queryAll();

            return $this->render('list-project-usage-request', [
                'model' => $model,
            ]);
        }
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
