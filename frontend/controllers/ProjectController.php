<?php

namespace frontend\controllers;

use Yii;
use common\models\Project;
use common\models\search\ProjectSearch;
use common\models\File;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for SippmProject model.
 */
class ProjectController extends Controller
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
     * Lists all SippmProject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SippmProject model.
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
     * Creates a new SippmProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post())) {
            $model->asg_id = 47;
            $model->proj_downloaded = 0;

            if($model->save()){
                $model->files = UploadedFile::getInstancesByName('files');

                if($model->files != null){
                    foreach($model->files as $file){
                        $fileModel = new File();
                        $fileDir = Yii::getAlias('@uploadDirTemplate') . "/" . $model->proj_title . "/";        

                        if(!is_dir($fileDir)){
                            mkdir($fileDir, 0777, true);
                        }

                        $fileDir .= $file->baseName . '.' . $file->extension;
                        $fileModel->file_name = $file->baseName;
                        $fileModel->file_path = $fileDir;
                        $fileModel->proj_id = $model->proj_id;

                        if($fileModel->save()){
                            $file->saveAs($fileDir);
                        }else{
                            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->proj_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SippmProject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fileModel = $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->proj_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'fileModel' => $fileModel,
        ]);
    }

    /**
     * Deletes an existing SippmProject model.
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
     * Finds the SippmProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SippmProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
