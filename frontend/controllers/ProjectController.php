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
use yii\db\Query;

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

    public function actionProjectByCategory($cat, $year=""){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $category = CategoryProject::find()->where(['cat_proj_id' => $cat])->one();
            $yearSearch = new Project();

            if($year != ""){
                $model = (new query())
                        ->select('sippm_sub_category_project.sub_cat_proj_id, sippm_sub_category_project.sub_cat_proj_name, count(sippm_project.proj_id) as count_proj')
                        ->from('sippm_sub_category_project')
                        ->leftJoin('sippm_assignment', 'sippm_assignment.sub_cat_proj_id = sippm_sub_category_project.sub_cat_proj_id AND sippm_assignment.asg_year = '.$year.'')
                        ->leftJoin('sippm_project', 'sippm_project.asg_id = sippm_assignment.asg_id AND sippm_project.deleted != 1')
                        ->where('sippm_sub_category_project.cat_proj_id = '.$cat.'')
                        ->groupBy('sippm_sub_category_project.sub_cat_proj_name, sippm_sub_category_project.sub_cat_proj_id')
                        ->orderBy(' count_proj DESC')
                        ->all();
            }else{
                $model = (new query())
                        ->select('sippm_sub_category_project.sub_cat_proj_id, sippm_sub_category_project.sub_cat_proj_name, count(sippm_project.proj_id) as count_proj')
                        ->from('sippm_sub_category_project')
                        ->leftJoin('sippm_assignment', 'sippm_assignment.sub_cat_proj_id = sippm_sub_category_project.sub_cat_proj_id')
                        ->leftJoin('sippm_project', 'sippm_project.asg_id = sippm_assignment.asg_id AND sippm_project.deleted != 1')
                        ->where('sippm_sub_category_project.cat_proj_id = '.$cat.'')
                        ->groupBy('sippm_sub_category_project.sub_cat_proj_name, sippm_sub_category_project.sub_cat_proj_id')
                        ->orderBy(' count_proj DESC')
                        ->all();
            }
            
            return $this->render('project-by-category',[
                'model' => $model,
                'category' => $category->cat_proj_name,
                'cat' => $cat,
                'yearSearch' => $yearSearch,
                'year' => $year,
            ]);
        }
    }

    public function actionProjectBySubCategory($sub_cat, $year){
        $session = Yii::$app->session;

        if(!isset($session['role'])){
            return $this->redirect(['/site/login']);
        }else{
            $sub_category = SubCategoryProject::find()->where(['sub_cat_proj_id' => $sub_cat])->one();
            if($year != ""){
                $model = (new Query())
                        ->select('sippm_project.proj_id, sippm_project.proj_title, sippm_project.proj_description, sippm_project.proj_used, sippm_project.proj_author, sippm_project.updated_at')
                        ->from('sippm_project')
                        ->innerJoin('sippm_assignment', 'sippm_assignment.asg_id = sippm_project.asg_id AND sippm_assignment.asg_year = '.$year.'')
                        ->innerJoin('sippm_sub_category_project', 'sippm_sub_category_project.sub_cat_proj_id = sippm_assignment.sub_cat_proj_id')
                        ->where('sippm_assignment.sub_cat_proj_id = '.$sub_cat.'')
                        ->groupBy('sippm_project.proj_title')
                        ->orderBy('sippm_project.proj_title ASC')
                        ->all();
            }else{
                $model = (new Query())
                        ->select('sippm_project.proj_id, sippm_project.proj_title, sippm_project.proj_description, sippm_project.proj_used, sippm_project.proj_author, sippm_project.updated_at')
                        ->from('sippm_project')
                        ->innerJoin('sippm_assignment', 'sippm_assignment.asg_id = sippm_project.asg_id')
                        ->innerJoin('sippm_sub_category_project', 'sippm_sub_category_project.sub_cat_proj_id = sippm_assignment.sub_cat_proj_id')
                        ->where('sippm_assignment.sub_cat_proj_id = '.$sub_cat.'')
                        ->groupBy('sippm_project.proj_title')
                        ->orderBy('sippm_project.proj_title ASC')
                        ->all();
            }
         
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
                $model->proj_used = 0;
                $model->proj_year = $year->format('Y');
                $model->proj_creator_class =(string)$session['kelas_id'];
                $model->proj_keyword = $_POST['proj_keyword'];

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
                    return $this->redirect(['project/list-project']);
                } else {
                    Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat membuat proyek');
    
                    // echo "<pre>";
                    // var_dump($model->errors);
                    // echo "</pre>";
                    // die;
                    
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
                $files = File::find()->where(['proj_id' => $model->proj_id])->andWhere('deleted!=1')->all();
                $oldProjName = $model->proj_title;

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
                        $model->proj_keyword = $_POST['proj_keyword'];

                        if($model->save()){
                            if($oldProjName != $model->proj_title){
                                $fileDefPath = Yii::getAlias('@uploadDirTemplate') . "/";
                                
                                rename($fileDefPath.$oldProjName, $fileDefPath.$model->proj_title);
                            
                                foreach($files as $file){
                                    $oldFile = $this->findFile($file->file_id);
                                    
                                    $oldFile->file_path = $fileDefPath.$model->proj_title . "/" . $oldFile->file_name;
                                    $oldFile->save();
                                }
                            }
                            
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
                            return $this->redirect(['project/list-project']);
                        }else{
                            Yii::$app->session->setFlash('error', 'Terjadi kesalahan saat mengubah proyek');
                            
                            return $this->goBack();
                        }
                    }
                }

                return $this->render('update', [
                    'model' => $model,
                    'fileModel' => $files,
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
                    $filePath = $file->file_path;

                    $zip->addFile($filePath, $file->file_name);
                }

                $zip->close();
                
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename=' . $project->proj_title.'.zip');
                header('Content-Transfer-Encoding: chunked');
                header('Pragma: no-cache');
                header('Expires: 0');
                readfile($project->proj_title);
                unlink($project->proj_title);
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

    private function findFile($file_id){
        if(($model = File::find()->where(['file_id' => $file_id])->andWhere('deleted!=1')->one()) !== null){
            return $model;
        }

        throw new NotFoundHttpException('File tidak ditemukan atau telah dihapus.');
    }

    private function getCategory($cat_proj_id){
        $category = CategoryProject::find()->where(['cat_proj_id' => $cat_proj_id])->andWhere('deleted!=1')->one();

        return $category->cat_proj_name;
    }

}
