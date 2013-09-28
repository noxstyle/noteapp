<?php

namespace app\js;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [select2 javascript library]
 *
 * @author Joni Lepistö <joni.lepisto@noxstyle.info>
 */
class NanoScrollerAsset extends AssetBundle
{
    public $sourcePath = '@app/js/nano-scroller';
    public $js = array(
        'jquery.nanoscroller.min.js',
    );
    public $css = array(
        'nanoscroller.css',
    );
    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
