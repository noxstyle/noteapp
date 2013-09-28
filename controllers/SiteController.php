<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db;
use app\models;

class SiteController extends Controller
{
	public function actions()
	{
		return array(
			'error' => array(
				'class' => 'yii\web\ErrorAction',
			),
			'captcha' => array(
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			),
		);
	}

	public function actionIndex()
	{
		/*\yii\base\View::registerJsFile(Yii::$app->basePath.'/js/controller.js');
		var_dump(Yii::$app->baseUrl);die(__METHOD__);
		var_dump(Yii::$app->basePath);die(__METHOD__);
		//$this->registerJs()
		# $tag = new \app\models\Tag;
		#$tag->setAttributes(array(
		#	'name' => 'test'
		# ));
		/*var_dump(Yii::$app->db);die(__METHOD__);
		$conn = new yii\db\Connection;
		var_dump($conn);die(__METHOD__);
		$y = new Yii;
		var_dump($y);die(__METHOD__);
		$db = new yii\Connection;
		var_dump($db);die(__METHOD__);
		var_dump(get_class_methods('Yii'));die(__METHOD__);
		var_dump(get_declared_classes());die(__METHOD__);
		var_dump(Yii::app());die(__METHOD__);*/
		return $this->render('index');
	}

	public function actionTest()
	{
		die(__METHOD__);
	}

	public function actionLogin()
	{
		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			return $this->goHome();
		} else {
			return $this->render('login', array(
				'model' => $model,
			));
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	public function actionContact()
	{
		$model = new ContactForm;
		if ($model->load($_POST) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');
			return $this->refresh();
		} else {
			return $this->render('contact', array(
				'model' => $model,
			));
		}
	}

	public function actionAbout()
	{
		return $this->render('about');
	}
}
