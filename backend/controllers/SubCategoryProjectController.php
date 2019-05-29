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
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File',
        ]);
        
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'xls, xlsx'], ['maxSize' => 1024*1024]);

        if (Yii::$app->request->post()) {
            if($_POST['form-type'] == 'dynamic'){
                //try catch here
                foreach($_POST['SubKategori'] as $subKategori){
                    $exists = SubCategoryProject::find()->where(['sub_cat_proj_name' => $subKategori])->andWhere('deleted!=1')->one();
                    
                    if($exists == null && $subKategori != ''){
                        $model->sub_cat_proj_name = $subKategori;
                        $model->cat_proj_id = $cat_proj_id;
                        $model->save();
                    }
                }

                return $this->redirect(['/category-project']);
            }else{
                //try catch here
                $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

                if($modelImport->fileImport && $modelImport->validate()){
                    $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $baseRow = 2;

                    while(!empty($sheetData[$baseRow]['A'])){
                        $exists = SubCategoryProject::find()->where(['sub_cat_proj_name' => $sheetData[$baseRow]['A']])->andWhere('deleted!=1')->one();

                        if($exists == null){
                            $model->setIsNewRecord(true);
                            $model->sub_cat_proj_name = $sheetData[$baseRow]['A'];
                            $model->cat_proj_id = $cat_proj_id;
                            $model->save();
                            $model->sub_cat_proj_id++;
                        }

                        $baseRow++;
                    }
                }

                return $this->redirect(['/category-project']);
            }
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
