<?php
namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Session;
use yii\helpers\Json;
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
use common\models\search\ProjectSearch;
use common\models\CategoryProject;
use common\models\SubCategoryProject;
use yii\sphinx\Query;
use yii\sphinx\MatchExpression;


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
        return [];
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
        $modelCount = Project::find()->where("deleted" != 1)->orderBy(['proj_downloaded' => SORT_DESC])->count();
        
        $modelNews = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->all();
        $modelNewsCount = Project::find()->where("deleted" != 1)->orderBy(['created_at' => SORT_DESC])->count();

        $modelComp = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->all();
        $modelCompCount = Project::find()->where("deleted" != 1)->andWhere(['not',['proj_cat_name' => "Matakuliah"]])->orderBy(['created_at' => SORT_DESC])->count();

        $categories = CategoryProject::find()->where("deleted!=1")->all();
        $yearList = Project::find()->select('proj_year')->distinct()->where('deleted!=1')->orderBy('proj_year ASC')->all();

        return $this->render('index', [
            'model' => $model,
            'modelNews' => $modelNews,
            'modelComp' => $modelComp,
            'modelCount' => $modelCount,
            'modelNewsCount' => $modelNewsCount,
            'modelCompCount' => $modelCompCount,
            'categories' => $categories,
            'yearList' => $yearList,
        ]);
    }

    public function actionLihatLainnya($type)
    {   
        $title = '';
        if($type == 'win_comp'){
            $model = Project::find()->where(['sts_win_id' => 1])->andWhere('deleted != 1')->orderBy('proj_title ASC')->all();
            $title = "Menang Kompetisi";
        }elseif($type == 'recently_added'){
            $model = Project::find()->where('deleted != 1')->orderBy('updated_at DESC')->all();
            $title = "Baru Ditambahkan";
        }elseif($type == 'comp'){
            $query = "SELECT p.proj_title, p.proj_description, p.proj_author, p.proj_id, p.updated_at FROM sippm_project p JOIN sippm_assignment sa ON sa.asg_id = p.asg_id WHERE sa.cat_proj_id = 2 AND p.deleted != 1 GROUP BY p.proj_id ORDER BY p.proj_title ASC";
            $model = Yii::$app->db->createCommand($query)->queryAll();
            $title = "Kompetisi";
        }elseif($type == 'matkul'){
            $query = "SELECT p.proj_title, p.proj_description, p.proj_author, p.proj_id, p.updated_at FROM sippm_project p JOIN sippm_assignment sa ON sa.asg_id = p.asg_id WHERE sa.cat_proj_id = 1 AND p.deleted != 1 GROUP BY p.proj_id ORDER BY p.proj_title ASC";
            $model = Yii::$app->db->createCommand($query)->queryAll();
            $title = "Matakuliah";
        }

        return $this->render('lihat-lainnya', [
            'model' => $model,
            'modelCount' => count($model),
            'title' => $title,
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
            // die($model->username.' '.$model->password);
            if($model->username === "" && $model->password === ""){
                // die("1");
                return $this->render('login', [
                    'model' => $model,
                    'error' => "username_password",
                ]);
            }
            if($model->username === ""){
                // die("2");
                return $this->render('login', [
                    'model' => $model,
                    'error' => "username",
                ]);
            }
            if($model->password === ""){
                // die("3");
                return $this->render('login', [
                    'model' => $model,
                    'error' => "password",
                ]);
            }
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
                    $nama = $datas['nama'];
                    $email = $datas['email'];
                    $role = $datas['role'];
                    
                    $session->set('username', $model->username);
                    $session->set('nama', $nama);
                    $session->set('email', $email);

                    if($role == "Mahasiswa"){
                        $dimId = $datas['dimId'];
                        $nim = $datas['nim'];
                        $kelas = $datas['kelas'];

                        if($session['username'] == 'if416004'){
                            $role = "Dosen";
                            $session->set('pegawaiId', 1);    
                        }

                        $session->set('dimId', $dimId);
                        $session->set('nim', $nim);
                        $session->set('kelas', $kelas);
                    }else{
                        $pegawaiId = $datas['pegawaiId'];
                        $nip = $datas['nip'];

                        $session->set('pegawaiId', $pegawaiId);
                        $session->set('nip', $nip);
                    }

                    $session->set('role', $role);
                    $session->close();

                    return $this->goBack();
                }else{
                    // Yii::$app->session->setFlash('error', 'Maaf, anda tidak terdaftar dalam sistem');
                    return $this->render('login', [
                        'model' => $model,
                        'error' => "data",
                    ]);
                }
            }else{
                Yii::$app->session->setFlash('error', 'Terjadi kesalahan dalam sistem');
                return $this->render('login', [
                    'model' => $model,
                    'error' => false,
                ]);
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

    public function actionSearchProject($searchWords, $searchCategory, $filterCategory = ''){
        $categories = CategoryProject::find()->where('deleted!=1')->all();
        $yearList = Project::find()->select('proj_year')->distinct()->where('deleted!=1')->orderBy('proj_year ASC')->all();

        // if($searchCategory == ""){
        //     $filterCategories = SubCategoryProject::find()->where('deleted!=1')->all();    
        // }else{
        //     $category = CategoryProject::find()->where(['cat_proj_name' => $searchCategory])->andWhere('deleted!=1')->one();
        //     $filterCategories = SubCategoryProject::find()->where(['cat_proj_id' => $category['cat_proj_id']])->andWhere('deleted!=1')->all();    
        // }

        $stopWordsRemoved = $this->removeStopWords(strtolower($searchWords));
        $preprocessed = trim(preg_replace('/\s+/', ' ', $stopWordsRemoved));
        $keywords = explode(' ', $preprocessed); 

        $query = new Query();
        $rows = $query->select('*')->from('sippm_project')->match(
            (new MatchExpression)->match(['proj_title' => $keywords])
                ->orMatch(['proj_author' => $keywords])
                ->orMatch(['proj_description' => $keywords])
                ->andFilterMatch(['proj_cat_name' => $searchCategory])
                ->andFilterMatch(['sub_cat_proj_name' => $filterCategory])
        )->all();

        return $this->render('search-result', [
            'searchRes' => $rows,
            'searchResCount' => count($rows),
            'categories' => $categories,
            'yearList' => $yearList,
            // 'filterCategories' => $filterCategories,
        ]);
    }

    public function actionAdvancedSearch($advKeywords = '', $advCategory = '', $advSubCategory = '', $advYear = '', $title = '', $description = '', $author = ''){
        $categories = CategoryProject::find()->where('deleted!=1')->all();
        $yearList = Project::find()->select('proj_year')->distinct()->where('deleted!=1')->orderBy('proj_year ASC')->all();

        $stopWordsRemoved = $this->removeStopWords(strtolower($advKeywords));
        $preprocessed = trim(preg_replace('/\s+/', ' ', $stopWordsRemoved));
        $keywords = explode(' ', $preprocessed); 

        if(isset($_GET['title']) && isset($_GET['description']) && isset($_GET['author'])){
            //If title, description and author checked
            
            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_title' => $keywords])
                    ->orFilterMatch(['proj_description' => $keywords])
                    ->orFilterMatch(['proj_author' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['title']) && isset($_GET['description'])){
            //If title and description checked

            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_title' => $keywords])
                    ->orFilterMatch(['proj_description' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['title']) && isset($_GET['author'])){
            //If title and author checked

            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_title' => $keywords])
                    ->orFilterMatch(['proj_author' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['description']) && isset($_GET['author'])){
            //If description and author checked

            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_description' => $keywords])
                    ->orFilterMatch(['proj_author' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['title'])){
            //If title checked

            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_title' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['description'])){
            //If description checked
            
            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_description' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else if(isset($_GET['author'])){
            //If author checked
            
            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_author' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }else{
            //If nothing checked

            $query = new Query();
            $rows = $query->select('*')->from('sippm_project')->match(
                (new MatchExpression)->match(['proj_title' => $keywords])
                    ->orFilterMatch(['proj_description' => $keywords])
                    ->orFilterMatch(['proj_author' => $keywords])
                    ->andFilterMatch(['proj_cat_name' => $advCategory])
                    ->andFilterMatch(['sub_cat_proj_name' => $advSubCategory])
                    ->andFilterMatch(['proj_year' => $advYear])
            )->all();
        }

        return $this->render('search-result', [
            'searchRes' => $rows,
            'searchResCount' => count($rows),
            'categories' => $categories,
            'yearList' => $yearList,
        ]);

    }

    private function removeStopWords($searchWords){
        $commonWords = require(dirname(__DIR__) . '/../files/stopwords.php');

        return preg_replace('/\b(' . implode('|', $commonWords) . ')\b/', '', $searchWords);
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

    public function actionGetSubCategory($categoryName){
        $category = CategoryProject::find()->where(['cat_proj_name' => $categoryName])->andWhere('deleted!=1')->one();
        $filterCategories = SubCategoryProject::find()->select('sub_cat_proj_name')->where(['cat_proj_id' => $category['cat_proj_id']])->andWhere('deleted!=1')->orderBy('sub_cat_proj_name ASC')->all();

        echo Json::encode($filterCategories);
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
