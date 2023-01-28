<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use app\forms\DashboardForm;

class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'roles'   => ['movies'],
                        'actions' => ['dashboard','create-content','update-content','delete-content','view-content','user-management','set-vip'],
                    ],
                    [
                        'allow'   => true,
                        'roles'   => ['@'],
                        'actions' => ['view-content'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    '' => ['post'],
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

    public function beforeAction($action)
    {
        if(!empty( Yii::$app->session->get('language'))){
            Yii::$app->language = Yii::$app->session->get('language');
        }

        return parent::beforeAction($action);
    }

    public function actionDashboard()
    {
        $model = new DashboardForm;
        $model->load(Yii::$app->request->get());

        return $this->render('dashboard', [
            'model'                 => $model,
        ]);
    }

    public function actionCreateContent()
    {
        $admin = Yii::$app->user->identity;
        $model = new DashboardForm;
        $list = [];

        $model->scenario = "create";
        $type    = 'create';
        $request = Yii::$app->request;
        $db      = Yii::$app->db->beginTransaction();
        try {
            if (!empty($request->post())) {
                if ($request->post('Create', false)) {
                    $cover = UploadedFile::getInstance($model, 'cover');
                    $path = UploadedFile::getInstance($model, 'path');
                    $model->load($request->post());
                    if(!empty($cover)){
                        $model->cover = $cover;
                    }

                    if(!empty($path)){
                        $model->path = $path;
                    }

                    if (!$model->validate()) {
                        throw new \Exception(current($model->getFirstErrors()));
                    }
                    $data = $model->saveContent();
                    $db->commit();
                    $user= Yii::$app->user->identity;

                    Yii::$app->session->setFlash('success', Yii::t('app','Content has been created successfully.'));
                    return $this->redirect(['admin/dashboard']);
                }
            }
        } catch (\Exception $e) {
            $db->rollback();
            Yii::$app->session->setFlash('error', Yii::t('app', $e->getMessage()));
            return $this->redirect(['admin/dashboard']);
        }

        return $this->renderAjax('createUpdateContent', compact('model','type'));
    }

    public function actionUpdateContent($id)
    {
        $admin = Yii::$app->user->identity;
        $model = new DashboardForm;
        $model->scenario = "update";
        $type    = 'update';
        $list = [];
        $request = Yii::$app->request;
        $db      = Yii::$app->db->beginTransaction();
        $model->getContent($id);
        try {
            if (!empty($request->post())) {
                if ($request->post('Update', false)) {
                    $cover = UploadedFile::getInstance($model, 'cover');
                    $path = UploadedFile::getInstance($model, 'path');
                    $model->load($request->post());
                    if (!$model->validate()) {
                        throw new \Exception(current($model->getFirstErrors()));
                    }
                    if(!empty($cover)){
                        $model->cover = $cover;
                    }

                    if(!empty($path)){
                        $model->path = $path;
                    }
                    $model->updateContent($id);
                    $db->commit();

                    $user= Yii::$app->user->identity;

                    Yii::$app->session->setFlash('success', Yii::t('app','Content has been updated successfully.'));
                    return $this->redirect(['admin/dashboard']);
                }
            }
        } catch (\Exception $e) {
            $db->rollback();
            Yii::$app->session->setFlash('error', Yii::t('app', $e->getMessage()));
            return $this->redirect(['admin/dashboard']);
        }

        return $this->render('createUpdateContent', compact('model','type'));
    }

    public function actionDeleteContent($id)
    {
        $form = new DashboardForm;
        $form->deleteContent($id);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Items has been deleted successfully.'));
        return $this->redirect(['admin/dashboard']);
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

    public function actionUserManagement()
    {
        $model = new DashboardForm;
        $model->load(Yii::$app->request->get());

        return $this->render('user_management', [
            'model'                 => $model,
        ]);
    }

    public function actionSetVip($id)
    {
        $form = new DashboardForm;
        $form->setVip($id);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Items has been set successfully.'));
        return $this->redirect(['admin/user-management']);
    }

    protected function throwFirstError($model)
    {
        throw new \Exception(current($model->getFirstErrors()));
    }
}
