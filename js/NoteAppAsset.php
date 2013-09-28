<?php

namespace app\js;
use yii\web\AssetBundle;

/**
 * This asset bundle provides the [knockoutjs javascript library]
 *
 * @author Joni Lepistö <joni.lepisto@noxstyle.info>
 */
class NoteAppAsset extends AssetBundle
{
    public $sourcePath = '@app/js/app';
    public $js = array(
        'app.js',
    );
    public $depends = array(
        'app\js\KnockoutAsset',
        'app\js\Select2Asset',
        'app\js\NiceScrollAsset',
    );
}
