<?php

namespace frontend\controllers;

use frontend\models\UsersModel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['restarans/index']);
        }

        $model = new UsersModel();
        $model->scenario = UsersModel::SCENARIO_LOGIN;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = UsersModel::findByEmail($model->email);

            if ($user && $user->validatePassword($model->password)) {

                if (Yii::$app->user->login($user, 3600 * 24)) {
                    return $this->redirect(['restaran/index']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Noto'g'ri elektron pochta yoki parol");
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        Yii::$app->response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        Yii::$app->response->headers->set('Pragma', 'no-cache');
        Yii::$app->response->headers->set('Expires', '0');

        Yii::$app->session->setFlash('success', 'Siz muvaffaqiyatli tizimdan chiqdingiz');

        return $this->redirect(['restaran/index']);
    }

    public function actionSignup()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['restaran/index']);
        }

        $signupModel = new UsersModel();
        $signupModel->scenario = UsersModel::SCENARIO_REGISTER;

        if ($signupModel->load(Yii::$app->request->post()) && $signupModel->validate()) {
            if ($signupModel->save()) {

                Yii::$app->user->login($signupModel, 3600 * 24);
                Yii::$app->session->setFlash('success', "Muvaffaqiyatli ro'yxatdan o'tdingiz!");
                return $this->redirect(['restarans/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Foydalanuvchini saqlashda xatolik.');
            }
        }

        return $this->render('signup', [
            'model' => $signupModel,
        ]);
    }
}