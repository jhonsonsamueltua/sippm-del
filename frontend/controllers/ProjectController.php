<?php

namespace frontend\controllers;

use Yii;
use common\models\Assignment;
use common\models\CategoryProject;
use common\models\Project;
use common\models\search\ProjectSearch;
use common\models\ProjectUsage;
use common\models\File;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use ZipArchive;

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

    public function beforeAction($action){
        $this->layout = 'main-2';

        return parent::beforeAction($action);
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

    public function actionViewProject($proj_id)
    {   
        $session = Yii::$app->session;
        
        $project = $this->findModel($proj_id);
        $assignmentModel = Assignment::find()->where(['asg_id' => $project->asg_id])->andWhere('deleted!=1')->one();
        $usageModel = ProjectUsage::find()->where(['proj_id' => $proj_id])->andWhere(['created_by' => $session['nama']])->andWhere('deleted!=1')->one();
        $files = File::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->all();

        return $this->render('view-project', [
            'model' => $project,
            'assignmentModel' => $assignmentModel,
            'usageModel' => $usageModel,
            'files' => $files,
        ]);
    }

    public function actionListProject()
    {   
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $model = Project::find()->where(["created_by" => $session['username']])->all();
        
            return $this->render('list-project', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new SippmProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($asg_id)
    {
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = new Project();
            $assignmentModel = Assignment::find()->where(['asg_id' => $asg_id])->andWhere('deleted!=1')->one();
            
            if ($model->load(Yii::$app->request->post())) {
                $model->asg_id = $asg_id;
                $model->proj_creator = $session['nama'];
                $model->proj_cat_name = $this->getCategory($assignmentModel->cat_proj_id);
                $model->proj_downloaded = 0;
    
                if($model->save()){
                    $model->files = UploadedFile::getInstancesByName('files');
    
                    if($model->files != null){
                        // $idx = 0; For extracting Zip
    
                        foreach($model->files as $file){
                            $fileModel = new File();
                            $fileName = $file->baseName . '.' . $file->extension;
                            $fileDir = Yii::getAlias('@uploadDirTemplate') . "/" . $model->proj_title . "/";
    
                            if(!is_dir($fileDir)){
                                mkdir($fileDir, 0777, true);
                            }
    
                            // if($file->extension == "zip"){ For extracting Zip
                            //     $zip = new ZipArchive();
                            //     $fileName = $_FILES['files']['tmp_name'][$idx];
    
                            //     if($zip->open($fileName)){
                            //         for($i = 0; $i < $zip->numFiles; $i++){
                            //             $stat = $zip->statIndex($i);
                            //             $fileModelInZip = new File();
                            //             $fileDir = Yii::getAlias('@uploadDirTemplate') . "/" . $model->proj_title . "/" . basename($stat['name']);
                                        
                            //             echo $fileDir . "<br>";
                            //             die();
                                        
                            //             $fileModelInZip->file_name = "";
                            //             $fileModelInZip->file_path = $fileDir;
                            //         }
                            //     }
                            // }else{
                            
                            $fileDir .= $fileName;
                            $fileModel->file_name = $fileName;
                            $fileModel->file_path = $fileDir;
                            $fileModel->proj_id = $model->proj_id;
    
                            if($fileModel->save(false)){
                                $file->saveAs($fileDir);
                            }else{
                                Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
                                
                                return $this->goBack();
                            }
                            // } For extracting Zip
                            
                            // $idx++; For extracting Zip
                        }
                    }
    
                    return $this->redirect(['view-project', 'proj_id' => $model->proj_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
    
                    return $this->goBack();
                }
            }
    
            return $this->render('create', [
                'model' => $model,
                'assignment' => $assignmentModel,
            ]);
        }
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
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = $this->findModel($id);
            
            if($model->created_by != $session['username']){
                Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk memodifikasi proyek berikut.');

                return $this->redirect(['/']);
            }else{
                $assignmentModel = Assignment::find()->where(['asg_id' => $model->asg_id])->andWhere('deleted!=1')->one();
                $fileModel = $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();

                if ($model->load(Yii::$app->request->post())) {
                    if($model->save()){
                        $model->files = UploadedFile::getInstancesByName('files');
                    
                        if($model->files != null){
                            foreach($model->files as $file){
                                $fileModel = new File();
                                $fileName = $file->baseName . '.' . $file->extension;
                                $fileDir = Yii::getAlias('@uploadDirTemplate') . "/" . $model->proj_title . "/" . $fileName;
            
                                $fileModel->file_name = $fileName;
                                $fileModel->file_path = $fileDir;
                                $fileModel->proj_id = $model->proj_id;
            
                                if($fileModel->save()){
                                    $file->saveAs($fileDir);
                                }else{
                                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat mengubah proyek');
                                    
                                    return $this->goBack();
                                }
                            }
                        }
                        
                        return $this->redirect(['view', 'id' => $model->proj_id]);
                    }else{
                        Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
                        
                        return $this->goBack();
                    }
                }

                return $this->render('update', [
                    'model' => $model,
                    'fileModel' => $fileModel,
                    'assignment' => $assignmentModel,
                ]);
            }
        }
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
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect('site/login');
        }else{
            $model = $this->findModel($id);
            
            if($model->created_by !== $session['username']){
                Yii::$app->session->setFlash('error', 'Maaf, anda tidak memiliki hak untuk memodifikasi proyek berikut.');

                return $this->redirect(['/']);
            }else{
                $model->softDelete();

                return $this->redirect(['index']);
            }
        }
    }

    public function actionDownloadProject($proj_id){
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $zip = new ZipArchive;
            $project = Project::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->one();
            $files = File::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->all();

            if($zip->open($project->proj_title, ZipArchive::CREATE) === TRUE){
                foreach($files as $file){
                    $zip->addFile($file->file_path, $file->file_name);
                }

                $zip->close();
                
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename=' . $project->proj_title);
                header('Pragma: no-cache');
                header('Expires: 0');
                readfile($project->proj_title);
                unlink($project->proj_title);
                
                $project->proj_downloaded += 1;
                $project->save();
            }
        }
    }

    // public function actionDownloadAttachment($file_id){
    //     $fileModel = File::find()->where(['file_id' => $file_id])->one();
    //     $path = Yii::getAlias('@webroot').'/';
    //     $file = $fileModel->file_path;

    //     if(file_exists($file)){
    //         Yii::$app->response->sendFile($file);
    //     }else{
    //         Yii::$app->session->setFlash('error', 'Maaf, file tidak ditemukan atau telah dihapus dari sistem');
    //     }
    // }

    public function actionRemoveAttachment($file_id){
        $fileModel = File::find()->where(['file_id' => $file_id])->one();
        $file = $fileModel->file_path;
        $projectId = $fileModel->proj_id;

        if(file_exists($file)){
            unlink($file);
        }

        $fileModel->delete();

        return $this->redirect(['update', 'id' => $projectId]);
    }


    /**
     * Finds the SippmProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SippmProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function findAssignment($asg_id){
        if(($model = Assignment::find()->where(['asg_id' => $asg_id])->andWhere('deleted!=1')->one() !== null)){
            return $model;
        }

        throw new NotFoundHttpException('Penugasan tidak ditemukan atau telah dihapus.');
    }

    private function getCategory($cat_proj_id){
        $category = CategoryProject::find()->where(['cat_proj_id' => $cat_proj_id])->andWhere('deleted!=1')->one();

        return $category->cat_proj_name;
    }

}
