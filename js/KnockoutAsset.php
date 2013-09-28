<?php

namespace app\js;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [knockoutjs javascript library]
 *
 * @author Joni Lepistö <joni.lepisto@noxstyle.info>
 */
class KnockoutAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';
    public $js = array(
        'knockout-2.3.0.js',
    );
}
