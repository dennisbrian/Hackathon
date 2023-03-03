<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserLoginSession;
use app\models\User;
use app\models\SignupForm;
use app\forms\DashboardForm;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        if (Yii::$app->user->can('movies')) {
            return $this->redirect(['admin/dashboard']);
        }
        $model = new DashboardForm;
        $model->load(Yii::$app->request->get());

        return $this->render('dashboard', [
            'model'                 => $model,
        ]);
    }

    public function actionPremium()
    {
        $model = new DashboardForm;
        $model->load(Yii::$app->request->get());

        return $this->render('premium', [
            'model'                 => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin($email_address = '')
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['admin/dashboard']);
        }

        $model = new LoginForm();
        $db    = Yii::$app->db->beginTransaction();
        try {
            $model->email = $email_address;
            if (Yii::$app->request->post('request', false)){
                $model->load(Yii::$app->request->post());
                if(empty($model->email)){
                    throw new \Exception(Yii::t('app','Please Enter Your Email Address'));
                }
                return $this->redirect(['site/request-code','email_address'=> $model->email]);
            }
            if (Yii::$app->request->post('submited', false)){
                $model->load(Yii::$app->request->post());
                if(empty($model->email)){
                    throw new \Exception(Yii::t('app','Please Enter Your Email Address'));
                }
                if(empty($model->password)){
                    throw new \Exception(Yii::t('app','Please Enter Your Password'));
                }
                $model->login();
                $user      = Yii::$app->user->identity;
                $db->commit();
                if(!empty($user)){
                    if($user->role == 'user'){
                        return $this->redirect(['index']);
                    }
                }
                return $this->redirect(['admin/dashboard']);
            }
        } catch(\Exception $e) {
          $db->rollback();
          Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister($email_address = '')
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['admin/dashboard']);
        }

        $model = new SignupForm();
        $db    = Yii::$app->db->beginTransaction();
        try {
            $model->email = $email_address;
            if (Yii::$app->request->post('request', false)){
                $model->load(Yii::$app->request->post());
                if(empty($model->email)){
                    throw new \Exception(Yii::t('app','Please Enter Your Email Address'));
                }
                return $this->redirect(['site/request-code','email_address'=> $model->email]);
            }
            if (Yii::$app->request->post('submited', false)){
                $model->load(Yii::$app->request->post());
                if(empty($model->email)){
                    throw new \Exception(Yii::t('app','Please Enter Your Email Address'));
                }
                if(empty($model->password)){
                    throw new \Exception(Yii::t('app','Please Enter Your Password'));
                }
                $model->signUp();
                $user      = Yii::$app->user->identity;
                $db->commit();
                Yii::$app->session->setFlash('success', Yii::t('app','User signUp successfully.'));
                return $this->redirect(['site/login']);
            }
        } catch(\Exception $e) {
          $db->rollback();
          Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionViewContent($id)
    {
        $model = new DashboardForm;
        $model->getContent($id);
        $model->load(Yii::$app->request->get());
        $user      = Yii::$app->user->identity;

        return $this->render('view_content', [
            'model'                 => $model,
        ]);
    }
}
