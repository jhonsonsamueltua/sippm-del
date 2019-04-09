<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectUsage;
use common\models\search\ProjectUsageSearch;
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
        $searchModel = new ProjectUsageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['created_by' => $session['nama']])->andWhere('deleted!=1')->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectUsage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $title = Project::find()->select('proj_title')->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->one();

        return $this->render('view', [
            'model' => $model,
            'projectTitle' => $title,
        ]);
    }

    /**
     * Creates a new ProjectUsage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($proj_id){
        $model = new ProjectUsage();
        $session = Yii::$app->session;

        if ($model->load(Yii::$app->request->post())){
            $model->proj_id = $proj_id;
            $model->sts_proj_usg_id = 1;
            $model->created_by = (isset($session['nama'])) ? $session['nama'] : "Jhonson Hutagaol";
            
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
