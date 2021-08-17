<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\forms\LoginForm;
use app\forms\RegistrationForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout', 'cabinet'],
                'rules' => [
                    [
                        'actions' => ['entry', 'registration'],
                        'allow'   => false,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'cabinet'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
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
        return $this->render('index');
    }

    public function actionEntry()
    {
        $request = Yii::$app->request;

        $model = new LoginForm();

        if ($model->load($request->post()) && $model->login()) {
            return $this->redirect('cabinet');
        }

        return $this->render('entry', ['model' => $model]);
    }

    public function actionRegistration()
    {
        $request = Yii::$app->request;

        $model = new RegistrationForm();

        if ($model->load($request->post()) && $model->register()) {
            return $this->redirect('cabinet');
        }

        return $this->render('registration', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCabinet()
    {
        /** @var User $user */
        $user   = Yii::$app->user->identity;
        $parent = $user->getParentUser();

        return $this->render('entry-confirm', [
            'model'    => $user,
            'ancestor' => $parent,
        ]);
    }


}
