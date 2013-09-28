<?php

namespace app\js;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [select2 javascript library]
 *
 * @author Joni Lepistö <joni.lepisto@noxstyle.info>
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@app/js/select2';
    public $js = array(
        'select2.min.js',
    );
    public $css = array(
        'select2.css',
    );
    public $depends = array(
        'yii\web\JqueryAsset',
    );
}
