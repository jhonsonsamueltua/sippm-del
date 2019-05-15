<?php

namespace frontend\controllers;

use Yii;
use common\models\Assignment;
use common\models\CategoryProject;
use common\models\SubCategoryProject;
use common\models\Project;
use common\models\search\ProjectSearch;
use common\models\ProjectUsage;
use common\models\File;
use frontend\controllers\AssignmentController;
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
        $this->layout = 'main';

        return parent::beforeAction($action);
    }

    public function actionViewProject($proj_id)
    {   
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $project = $this->findModel($proj_id);
            $assignmentModel = Assignment::find()->where(['asg_id' => $project->asg_id])->andWhere('deleted!=1')->one();
            $usageModel = ProjectUsage::find()->where(['proj_id' => $proj_id])->andWhere(['created_by' => $session['username']])->andWhere('deleted!=1')->one();
            $files = File::find()->where(['proj_id' => $proj_id])->andWhere('deleted!=1')->all();

            return $this->render('view-project', [
                'model' => $project,
                'assignmentModel' => $assignmentModel,
                'usageModel' => $usageModel,
                'files' => $files,
            ]);
        }
    }

    public function actionListProject()
    {   
        $session = Yii::$app->session;
        
        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $model = Project::find()->where(["created_by" => $session['username']])->andWhere('deleted!=1')->all();
        
            return $this->render('list-project', [
                'model' => $model,
            ]);
        }
    }

    public function actionProjectByCategory($cat){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $category = CategoryProject::find()->where(['cat_proj_id' => $cat])->one();

            $query = 'SELECT sippm_sub_category_project.sub_cat_proj_id, sippm_sub_category_project.sub_cat_proj_name, count(sippm_project.proj_id) as count_proj FROM sippm_sub_category_project LEFT JOIN sippm_assignment ON sippm_assignment.sub_cat_proj_id = sippm_sub_category_project.sub_cat_proj_id LEFT JOIN sippm_project ON sippm_project.asg_id = sippm_assignment.asg_id WHERE sippm_sub_category_project.cat_proj_id = '.$cat.' GROUP BY sippm_sub_category_project.sub_cat_proj_name, sippm_sub_category_project.sub_cat_proj_id ORDER BY count_proj DESC';
            $model = Yii::$app->db->createCommand($query)->queryAll();
            
            return $this->render('project-by-category',[
                'model' => $model,
                'category' => $category->cat_proj_name,
            ]);
        }
    }

    public function actionProjectBySubCategory($sub_cat){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $sub_category = SubCategoryProject::find()->where(['sub_cat_proj_id' => $sub_cat])->one();

            $query = 'SELECT sippm_project.proj_id, sippm_project.proj_title, sippm_project.proj_description, sippm_project.proj_downloaded, sippm_project.proj_author, sippm_project.updated_at FROM sippm_project JOIN sippm_assignment ON sippm_assignment.asg_id = sippm_project.asg_id JOIN sippm_sub_category_project ON sippm_sub_category_project.sub_cat_proj_id = sippm_assignment.sub_cat_proj_id WHERE sippm_assignment.sub_cat_proj_id = '.$sub_cat.' GROUP BY sippm_project.proj_title ORDER BY sippm_project.proj_title ASC';
            $model = Yii::$app->db->createCommand($query)->queryAll();
         
            return $this->render('project-by-sub-category',[
                'model' => $model,
                'sub_category' => $sub_category,
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
        AssignmentController::openCloseAssignment();

        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = new Project();
            $year = new \DateTime();
            $assignmentModel = Assignment::find()->where(['asg_id' => $asg_id])->andWhere('deleted!=1')->one();
            
            if ($model->load(Yii::$app->request->post())) {

                // Validasi waktu submit
                date_default_timezone_set("Asia/Bangkok");
                $now = new \DateTime();
                $batas_submit = new \DateTime($assignmentModel->asg_end_time);

                if($now > $batas_submit){
                    $assignmentModel->sts_asg_id = 2;
                    return $this->render('create', [
                        'model' => $model,
                        'assignment' => $assignmentModel,
                        'late' => true,
                    ]);
                }
                $model->asg_id = $asg_id;
                $model->proj_creator = $session['nama'];
                $model->proj_cat_name = $this->getCategory($assignmentModel->cat_proj_id);
                $model->proj_downloaded = 0;
                $model->proj_year = $year->format('Y');
                $model->proj_creator_class =(string)$session['kelas_id'];
                if($model->save()){
                    $model->files = UploadedFile::getInstancesByName('files');
    
                    if($model->files != null){
    
                        foreach($model->files as $file){
                            $fileModel = new File();
                            $fileName = $file->baseName . '.' . $file->extension;
                            $fileDir = Yii::getAlias('@uploadDirTemplate') . "/" . $model->proj_title . "/";
    
                            if(!is_dir($fileDir)){
                                mkdir($fileDir, 0777, true);
                            }
                            
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
                        }
                    }

                    Yii::$app->session->setFlash('succes', 'Selamat, anda berhasil mengunggah proyek.');
                    return $this->redirect(['assignment/assignment-student']);
                } else {
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
    
                    return $this->render('create', [
                        'model' => $model,
                        'assignment' => $assignmentModel,
                        'late' => false,
                    ]);
                }
            }

            return $this->render('create', [
                'model' => $model,
                'assignment' => $assignmentModel,
                'late' => false,
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
        AssignmentController::openCloseAssignment();

        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['site/login']);
        }else{
            $model = $this->findModel($id);
            
            if($model->created_by != $session['username']){
                Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk memodifikasi proyek tersebut.');

                return $this->redirect(['/']);
            }else{
                $assignmentModel = Assignment::find()->where(['asg_id' => $model->asg_id])->andWhere('deleted!=1')->one();
                $fileModel = $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();

                if ($model->load(Yii::$app->request->post())) {
                    // Validasi waktu submit
                    date_default_timezone_set("Asia/Bangkok");
                    $now = new \DateTime();
                    $batas_submit = new \DateTime($assignmentModel->asg_end_time);
                    
                    if($now > $batas_submit){
                        $assignmentModel->sts_asg_id = 2;
                        return $this->render('update', [
                            'model' => $model,
                            'fileModel' => $fileModel,
                            'assignment' => $assignmentModel,
                            'late' => true,
                        ]);
                    }else{
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
                            Yii::$app->session->setFlash('succes', 'Selamat, anda berhasil mengubah proyek.');
                            // return $this->redirect(['update', 'id' => $id]);
                            return $this->redirect(['assignment/assignment-student']);
                        }else{
                            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat mengubah proyek');
                            
                            return $this->goBack();
                        }
                    }
                }

                return $this->render('update', [
                    'model' => $model,
                    'fileModel' => $fileModel,
                    'assignment' => $assignmentModel,
                    'late' => false,
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
                Yii::$app->session->setFlash('error', 'Anda tidak memiliki hak untuk memodifikasi proyek terebut.');

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
                header('Content-Disposition: attachment; filename=' . $project->proj_title.'.zip');
                header('Content-Transfer-Encoding: chunked');
                header('Pragma: no-cache');
                header('Expires: 0');
                readfile($project->proj_title);
                unlink($project->proj_title);
                
                $project->proj_downloaded += 1;
                $project->save();
            }
        }
    }

    public function actionDownloadAttachment($file_id){
        $fileModel = File::find()->where(['file_id' => $file_id])->one();
        $path = Yii::getAlias('@webroot').'/';
        $file = $fileModel->file_path;

        if(file_exists($file)){
            Yii::$app->response->sendFile($file);
        }else{
            Yii::$app->session->setFlash('error', 'Maaf, file tidak ditemukan atau telah dihapus dari sistem');
        }
    }

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
