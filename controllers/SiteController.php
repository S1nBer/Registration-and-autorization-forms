<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Users;
use app\models\Menu;
use app\models\MenuQuery;
use app\models\RegistrationForm;


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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
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

        return $this->goHome();
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

    public function actionSay($message = 'Привет')
    {
        return $this->render('say', ['message' => $message]);
    }

    public function actionEntry(){
        $request = Yii::$app->request;
        $model = new EntryForm();

        if ($model->load($request->post()) && $model-> validate()){
            $users = new Users();
            $users = Users::findOne(['name' => $model['name'], 'email' => $model['email']]);
            $node = Menu::findOne(['name' => $model['email']]);
            $ancestor = new Users();
            if($parent = $node->parents(1)->one()){
                $ancestor = Users::findOne(['email' => $parent['name']]);   
            }
            if($users){
                return $this->render('entry-confirm', ['model' => $users, 'ancestor' => $ancestor]);
            }
            else{
                return $this->render('entry', ['model' => $model, 'message' => 'Ошибка, пользователя с такими именем и email не существует']);
            } 
        }
        else{
            return $this->render('entry', ['model' => $model]);
        }
    }

    public function actionRegistration(){

        function random(){
            $n = rand(1000000000, 9999999999);
            $id = new Users();
            while($id = Users::findOne(['partner_id' => $n])){
                $n = rand(1000000000, 9999999999);
            }
            return $n;
        }

        $request = Yii::$app->request;
        $model = new RegistrationForm();

        if($model->load($request->post()) && $model-> validate()){
            $users = new Users();
            $users = Users::findOne(['email' => $model['email']]);
            if($users){
                return $this->render('registration', ['model' => $model, 'message' => 'Ошибка, пользователь с таким email уже зарегистрирован']);
            }
            $partner = new Users();
            $partner = Users::findOne(['partner_id' => $model['partner_id']]);
            if(!$partner){
                return $this->render('registration', ['model' => $model, 'message' => 'Ошибка, пользователя с таким partner_id не существует']);
            }
            $new_user = new Users();
            $new_user->name = $model['name'];
            $new_user->email = $model['email'];
            $new_user->partner_id = random();
            $new_user->date = date('Y-m-d');
            $new_user->save();
            $parent = new Users();
            $parent = Users::findOne(['partner_id' => $model['partner_id']]);
            $node = Menu::findOne(['name' => $parent['email']]);
            $client = new Menu(['name' => $model['email']]);
            $client->appendTo($node);
            return $this->render('entry-confirm', ['model' => $new_user, 'ancestor' => $parent]);
        }
        else{
            return $this->render('registration', ['model' => $model]);
        }
    }
}
