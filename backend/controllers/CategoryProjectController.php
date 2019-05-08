<?php

namespace backend\controllers;

use Yii;
use common\models\CategoryProject;
use common\models\search\CategoryProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryProjectController implements the CRUD actions for CategoryProject model.
 */
class CategoryProjectController extends Controller
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
     * Lists all CategoryProject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categories = CategoryProject::find()->where('deleted!=1')->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }

    /**
     * Displays a single CategoryProject model.
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
     * Creates a new CategoryProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryProject();

        if ($model->load(Yii::$app->request->post())) {

            if(!$model->save()){
                Yii::$app->session->setFlash('error', 'Gagal menambahkan kategori.');
            }else{
                Yii::$app->session->setFlash('success', 'Kategori berhasil ditambahkan.');
            }

            return $this->redirect(['/category-project']);
        }

        return $this->redirect(['/category-project']);
    }

    /**
     * Updates an existing CategoryProject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cat_proj_id)
    {
        $model = $this->findModel($cat_proj_id);

        if ($model->load(Yii::$app->request->post())) {
            
            if(!$model->save()){
                Yii::$app->session->setFlash('error', 'Gagal menambahkan kategori.');
            }else{                
                Yii::$app->session->setFlash('success', 'Kategori berhasil ditambahkan.');
            }
            
            return $this->redirect(['/category-project']);
        }

        return $this->redirect(['/category-project']);
    }

    /**
     * Deletes an existing CategoryProject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cat_proj_id)
    {
        $this->findModel($cat_proj_id)->softDelete();

        return $this->redirect(['/category-project']);
    }

    /**
     * Finds the CategoryProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryProject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
