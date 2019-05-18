<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Project;

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
                        'actions' => ['logout', 'index', 'all-project'],
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

        $modelTop = Project::find()->where("deleted!=1")->orderBy(['proj_downloaded' => SORT_DESC])->limit(10)->all();
        return $this->render('index',[
            'projectCount' => $projectCount,
            'modelTop' => $modelTop,
        ]);
    }

    public function actionAllProject()
    {   
        $project = Project::find()->where('deleted!=1')->all();
        $projectCount = Project::find()->where('deleted!=1')->count();

        return $this->render('all-project',[
            'projectCount' => $projectCount,
            'project' => $project,
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
