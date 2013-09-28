<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\config;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends \app\extensions\AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = array(
		'css/site.css',
		'css/styles.css',
		'http://fonts.googleapis.com/css?family=Cinzel+Decorative:400,700,900',
		'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,700,600,800',
		'http://fonts.googleapis.com/css?family=Gochi+Hand',
		'http://fonts.googleapis.com/css?family=Josefin+Sans',
	);
	public $js = array(
	);
	public $depends = array(
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	);
}
