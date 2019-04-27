<?php
namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use  yii\web\Session;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\User;
use frontend\models\ContactForm;
use common\models\Project;
/**
 * Site controller
 */
class SiteController extends Controller
{
    const BASE_URL = "https://cis.del.ac.id/api/sippm-api";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['logout', 'signup', 'about', 'contact'],
            //     'rules' => [
            //         [
            //             'actions' => ['signup'],
            //             'allow' => true,
            //             'roles' => ['?'],
            //         ],
            //         [
            //             'actions' => ['logout'],
            //             'allow' => true,
            //             // 'roles' => ['@'],
            //         ],
            //         [
            //             'actions' => ['contact'],
            //             'allow' => true,
            //             // 'roles' => ['@'],
            //             'matchCallback' => function ($rule, $action) {
            //                 // return User::isUserStudent(Yii::$app->user->identity->username);
            //             }
            //        ],
            //        [
            //             'actions' => ['about'],
            //             'allow' => true,
            //             // 'roles' => ['@'],
            //             'matchCallback' => function ($rule, $action) {
            //                 // return User::isUserLecturer(Yii::$app->user->identity->username);
            //             }
            //    ],
            //     ],
            // ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {   
        $model = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->limit(5)->all();
        $modelNews = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->limit(3)->all();

        $modelCount = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->count();
        $modelNewsCount = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->count();

        $modelComp = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->all();
        $modelCompCount = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->count();
        return $this->render('index', [
            'model' => $model,
            'modelNews' => $modelNews,
            'modelComp' => $modelComp,
            'modelCount' => $modelCount,
            'modelNewsCount' => $modelNewsCount,
            'modelCompCount' => $modelCompCount,
        ]);
    }

    public function actionLihatLainnya($type)
    {   
        if($type == 1){
            $modelCount = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->count();
            $pagination = new Pagination(['totalCount' => $modelCount, 'pageSize' => 2]);

            $model = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->limit(3)->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        }else if($type == 2){
            $modelCount = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->count();
            $pagination = new Pagination(['totalCount' => $modelCount, 'pageSize' => 2]);

            $model = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->limit(3)->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        }else if($type == 3){
            $modelCount = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->count();
            $pagination = new Pagination(['totalCount' => $modelCount, 'pageSize' => 2]);

            $model = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->limit(3)->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        }
        return $this->render('lihat-lainnya', [
            'model' => $model,
            'type' => $type,
            'pagination' => $pagination,
        ]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {   
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            $response = $client->createRequest()
                                ->setMethod('POST')
                                ->setUrl('https://cis.del.ac.id/api/sippm-api/do-auth')
                                ->setData([
                                    'username' => $model->username,
                                    'password' => $model->password
                                ])
                                ->send();

            if($response->isOk){
                if($response->data['result'] == "true"){
                    $session = Yii::$app->session;
                    $session->open();

                    $datas = $response->data['data'];
                    $role = $datas['role'];
                    $session['username'] = $model->username;

                    if($role == "Mahasiswa"){
                        $dimId = $datas['dimId'];
                        echo $nim = $datas['nim'];
                        $nama = $datas['nama'];
                        $email = $datas['email'];
                        $kelas = $datas['kelas'];
                        if($session['username'] == 'if416004'){
                            $role = "Dosen";
                        }

                        $session->set('dimId', $dimId);
                        $session->set('nim', $nim);
                        $session->set('nama', $nama);
                        $session->set('email', $email);
                        $session->set('kelas', $kelas);
                    }else{
                        $nip = $datas['nip'];

                        $session->set('nama', $nama);
                        $session->set('email', $email);
                        $session->set('nip', $nip);
                    }

                    $session->set('role', $role);
                    $session->close();

                    return $this->goBack();
                }else{
                    Yii::$app->session->setFlash('error', 'Maaf, anda tidak terdaftar dalam sistem');
                    
                    return $this->render('login', [
                        'model' => $model,
                        'error' => true,
                    ]);
                }
            }else{
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan dalam sistem');
            }

            return $this->goHome();
        } else {

            return $this->render('login', [
                'model' => $model,
                'error' => false,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;

        if(isset($session['role'])){
            $session->destroy();
        }

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    // public function actionSignup()
    // {
    //     $model = new SignupForm();
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($user = $model->signup()) {
    //             if (Yii::$app->getUser()->login($user)) {
    //                 return $this->goHome();
    //             }
    //         }
    //     }

    //     return $this->render('signup', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    // public function actionRequestPasswordReset()
    // {
    //     $model = new PasswordResetRequestForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

    //             return $this->goHome();
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    //         }
    //     }

    //     return $this->render('requestPasswordResetToken', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    // public function actionResetPassword($token)
    // {
    //     try {
    //         $model = new ResetPasswordForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }

    //     if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    //         Yii::$app->session->setFlash('success', 'New password saved.');

    //         return $this->goHome();
    //     }

    //     return $this->render('resetPassword', [
    //         'model' => $model,
    //     ]);
    // }
}
