<?php

namespace backend\controllers;

use Yii;
use common\models\Assignment;
use common\models\Project;
use common\models\ProjectUsage;
use common\models\search\ProjectUsageSearch;
use common\models\StatusProjectUsage;
use common\models\CategoryUsage;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Html;

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
        // $session = Yii::$app->session;
        
        // if(!isset($session['role'])){
        //     return $this->redirect(['site/login']);
        // }else{
            $modelRequestCount = ProjectUsage::find()->Where('alternate=1')->andWhere(['sts_proj_usg_id' => 1])->andWhere('deleted!=1')->count();
            $pagination = new Pagination(['totalCount' => $modelRequestCount, 'pageSize' => 5]);
            $query = 'SELECT PU.proj_usg_id, PU.proj_usg_creator, PU.proj_usg_usage, PU.sts_proj_usg_id, PU.cat_usg_id, PU.proj_id, PU.created_by, PU.updated_at, P.proj_title, A.asg_creator FROM sippm_project_usage PU JOIN sippm_project P ON PU.proj_id = P.proj_id JOIN sippm_assignment A ON A.asg_id = P.asg_id WHERE PU.alternate = 1 AND PU.deleted != 1 AND PU.sts_proj_usg_id = 1';
            $modelRequestUsers = Yii::$app->db->createCommand($query)->queryAll();
            $modelRequestUsersCount = count($modelRequestUsers);

            return $this->render('index', [
                'modelRequestUsers' => $modelRequestUsers,
                'modelRequestCount' => $modelRequestCount,
                'modelRequestUsersCount' => $modelRequestUsersCount,
                'pagination' => $pagination,
            ]);
        // }
    }

    /**
     * Displays a single ProjectUsage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProjectUsage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectUsage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->proj_usg_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProjectUsage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->proj_usg_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectUsage model.
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

    public function actionAcceptRequest($proj_usg_id){
        // $session = Yii::$app->session;

        // if(!isset($session['role'])){
            // return $this->redirect(['site/login']);
        // }else if($session['role' == 'Mahasiswa']){
        //     Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman ini');
            
        //     return $this->goHome();
        // }else{
            $request = ProjectUsage::find()->where(['proj_usg_id' => $proj_usg_id])->andWhere('deleted!=1')->one();

            $request->sts_proj_usg_id = 2;
            $request->save();

            $status = $this->getProjectRequestStatus($request->sts_proj_usg_id);
            $this->sendResponseEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['index']);
        // }
    }    
    
    public function actionRejectRequest($proj_usg_id){
        // $session = Yii::$app->session;

        // if(!isset($session['role'])){
        //     return $this->redirect(['site/login']);
        // }else if($session['role' == 'Mahasiswa']){
        //     Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk mengakses halaman ini');
            
        //     return $this->goHome();
        // }else{
            $request = ProjectUsage::find()->where(['proj_usg_id' => $proj_usg_id])->andWhere('deleted!=1')->one();

            $request->sts_proj_usg_id = 3;
            $request->save();

            $status = $this->getProjectRequestStatus($request->sts_proj_usg_id);
            $this->sendResponseEmail($request->user_email, $status, $request->proj_id);

            return $this->redirect(['index']);
        // }
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

    private function getProjectRequestStatus($sts_id){
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

    public function getCategoryPenggunaan($id){
        $model = CategoryUsage::find()->where(['cat_usg_id' => $id])->one();
        $category = $model->cat_usg_name;
        
        return $model->cat_usg_name;
    }

}
