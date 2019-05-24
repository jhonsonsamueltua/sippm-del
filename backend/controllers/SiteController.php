<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Project;
use common\models\SubCategoryProject;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'all-project', 'category-project'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $projectCount = Project::find()->where('deleted!=1')->count();
        $projectWinCompetitionCount = Project::find()->where("deleted!=1")->andWhere(['sts_win_id' => 1])->count();
        $subCategoryCount = SubCategoryProject::find()->where("deleted!=1")->count();
        $modelTop = Project::find()->where("deleted!=1")->orderBy(['proj_downloaded' => SORT_DESC])->limit(10)->all();

        $query = "SELECT sa.asg_year, count(sp.proj_id) FROM sippm_assignment sa LEFT JOIN sippm_project sp ON sa.asg_id = sp.asg_id WHERE sp.deleted != 1 GROUP BY sa.asg_year ORDER BY sa.asg_year DESC";
        $modelGrafik = Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index',[
            'projectCount' => $projectCount,
            'projectWinCompetitionCount' => $projectWinCompetitionCount,
            'subCategoryCount' => $subCategoryCount,
            'modelTop' => $modelTop,
            'modelGrafik' => $modelGrafik,
        ]);
    }

    public function actionCategoryProject(){
        $query = "SELECT ss.sub_cat_proj_id, ss.sub_cat_proj_name, count(sp.proj_id), sc.cat_proj_name FROM sippm_sub_category_project ss LEFT JOIN sippm_assignment sa ON sa.sub_cat_proj_id = ss.sub_cat_proj_id LEFT JOIN sippm_project sp ON sp.asg_id = sa.asg_id AND sp.deleted != 1 JOIN sippm_category_project sc ON sc.cat_proj_id = ss.cat_proj_id GROUP BY ss.sub_cat_proj_name, ss.sub_cat_proj_id ORDER BY count(sp.proj_id) DESC";
        $modelCategory = Yii::$app->db->createCommand($query)->queryAll();
        // echo '<pre>';
        // die(var_dump($modelCategory));
        // echo '</pre>';
        return $this->render('category-project',[
            'modelCategory' => $modelCategory,
        ]);
    }

    public function actionAllProject($type = "")
    {   
        if($type == ""){
            $project = Project::find()->where('deleted!=1')->all();
            $projectCount = Project::find()->where('deleted!=1')->count();
            $title = "Semua Proyek";
        }else if($type == "winComp"){
            $project = Project::find()->where("deleted!=1")->andWhere(['sts_win_id' => 1])->all();
            $projectCount = Project::find()->where("deleted!=1")->andWhere(['sts_win_id' => 1])->count();
            $title = "Menang Kompetisi";
        }else{
            $sub_category = SubCategoryProject::find()->where(['sub_cat_proj_id' => $type])->one();

            $query = 'SELECT sippm_project.proj_id FROM sippm_project JOIN sippm_assignment ON sippm_assignment.asg_id = sippm_project.asg_id JOIN sippm_sub_category_project ON sippm_sub_category_project.sub_cat_proj_id = sippm_assignment.sub_cat_proj_id WHERE sippm_assignment.sub_cat_proj_id = '.$type.' GROUP BY sippm_project.proj_title ORDER BY sippm_project.proj_title ASC';
            $project = Yii::$app->db->createCommand($query)->queryAll();
            $title = "Proyek ".$sub_category->sub_cat_proj_name;

            return $this->render('project-by-sub-category',[
                'projectCount' => count($project),
                'project' => $project,
                'title' => $title,
            ]);
        }

        return $this->render('all-project',[
            'projectCount' => $projectCount,
            'project' => $project,
            'title' => $title,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {   
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->username == "" && $model->password == ""){
                return $this->render('login', [
                    'model' => $model,
                    'error' => "username_password",
                ]);
            }
            if($model->username == ""){
                return $this->render('login', [
                    'model' => $model,
                    'error' => "username",
                ]);
            }
            if($model->password == ""){
                return $this->render('login', [
                    'model' => $model,
                    'error' => "password",
                ]);
            }
            
            if(!$model->loginAdmin()){
                return $this->render('login', [
                    'model' => $model,
                    'error' => "data",
                ]);
            }else{
                return $this->goBack();
            }
            
        } else {
            return $this->render('login', [
                'model' => $model,
                'error' => false,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public static function tgl_indo($tanggal){
        $bulan = array (
        1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
         
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}
