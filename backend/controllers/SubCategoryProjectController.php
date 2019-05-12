<?php

namespace backend\controllers;

use Yii;
use common\models\SubCategoryProject;
use common\models\search\SubCategoryProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubCategoryProjectController implements the CRUD actions for SubCategoryProject model.
 */
class SubCategoryProjectController extends Controller
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
     * Lists all SubCategoryProject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubCategoryProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubCategoryProject model.
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
     * Creates a new SubCategoryProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cat_proj_id)
    {
        $model = new SubCategoryProject();

        if ($model->load(Yii::$app->request->post())) {
            $model->cat_proj_id = $cat_proj_id;

            if(!$model->save()){
                Yii::$app->session->setFlash('error', 'Gagal menambahkan sub kategori.');
            }else{
                Yii::$app->session->setFlash('success', 'Sub kategori berhasil ditambahkan.');
            }
             
            return $this->redirect(['/category-project']);
        }

        return $this->redirect(['/category-project']);
    }

    /**
     * Updates an existing SubCategoryProject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($sub_cat_proj_id)
    {
        $model = $this->findModel($sub_cat_proj_id);

        if ($model->load(Yii::$app->request->post())) {
            
            if(!$model->save()){
                Yii::$app->session->setFlash('error', 'Gagal mengubah sub kategori.');
            }else{
                Yii::$app->session->setFlash('success', 'Sub kategori berhasil diubah.');
            }

            return $this->redirect(['/category-project']);
        }

        return $this->redirect(['/category-project']);
    }

    /**
     * Deletes an existing SubCategoryProject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($sub_cat_proj_id)
    {
        $this->findModel($sub_cat_proj_id)->softDelete();

        return $this->redirect(['/category-project']);
    }

    /**
     * Finds the SubCategoryProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubCategoryProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubCategoryProject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
