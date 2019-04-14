<?php
namespace frontend\controllers;

use Yii;
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    // public function actionIndex()
    // {
       
    //     return $this->render('index');
    // }
    public function actionIndex()
    {   
        $model = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->limit(3)->all();
        $modelNews = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
        
        return $this->render('index', [
            'model' => $model,
            'modelNews' => $modelNews,
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
                    $session->close();

                    $datas = $response->data['data'];
                    $role = $datas['role'];
                    
                    if($role == "Mahasiswa"){
                        $dimId = $datas['dimId'];
                        $nama = $datas['nama'];
                        $email = $datas['email'];
                        $kelas = $datas['kelas'];
                        
                        $session->set('dimId', $dimId);
                        $session->set('nama', $nama);
                        $session->set('email', $email);
                        $session->set('kelas', $kelas);

                        // $role = "Dosen";
                    }else{
                        $nip = $datas['nip'];

                        $session->set('nama', $nama);
                        $session->set('email', $email);
                        $session->set('nip', $nip);
                    }

                    $session->set('role', $role);
                    $session->close();
                    // echo $session['dimId'] . "<br>";
                    // echo $session['nama'] . "<br>";
                    // echo $session['email'] . "<br>";
                    // echo $session['kelas'] . "<br>";
                    // echo $session['role'];

                    return $this->goBack();
                }else{
                    Yii::$app->session->setFlash('error', 'Maaf, anda tidak terdaftar dalam sistem');
                    return $this->goBack();
                }
            }else{
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan dalam sistem');
            }

            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
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
        // Yii::$app->user->logout();
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
