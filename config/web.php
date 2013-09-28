<?php

$config = array(
	'id' => 'bootstrap',
	'basePath' => dirname(__DIR__),
	'components' => array(
		'cache' => array(
			'class' => 'yii\caching\FileCache',
		),
		'user' => array(
			'identityClass' => 'app\models\User',
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'log' => array(
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => array(
				array(
					'class' => 'yii\log\FileTarget',
					'levels' => array('error', 'warning'),
				),
			),
		),
		'db' => array(
			'class' => 'yii\db\Connection',
			'dsn' => 'sqlite:'.dirname(__DIR__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'test.db',

			# DSN for MySQL
			# 'dsn' => 'mysql:host=localhost;dbname=blog',

			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',

			# Set tbl prefix here if needed
			# 'tablePrefix' => 'notes_',

			# Db Schema Caching
			'enableSchemaCache' => !YII_DEBUG,
		),
	),
	'modules' => array(
		'class' => 'yii\gii\Module',
		'password' => '',
	),
	'params' => require(__DIR__ . '/params.php'),
);

if (YII_ENV_DEV) {
	$config['preload'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
