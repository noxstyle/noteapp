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
		return $this->render('index');
	}
}
