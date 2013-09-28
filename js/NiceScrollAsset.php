<?php

namespace app\js;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [select2 javascript library]
 *
 * @author Joni Lepistö <joni.lepisto@noxstyle.info>
 */
class NiceScrollAsset extends AssetBundle
{
    public $sourcePath = '@app/js/nice-scroll';
    public $js = array(
        'jquery.nicescroll.min.js',
    );
    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
