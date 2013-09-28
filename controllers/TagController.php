<?php

namespace app\controllers;

class TagController extends \yii\web\Controller
{
	public function actionCreate()
	{
		return $this->render('create');
	}

	public function actionDelete()
	{
		return $this->render('delete');
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

}
