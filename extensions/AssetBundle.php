<?php

namespace app\extensions;

/**
 * Extension for AssetBundle to allow registering external resources
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public function registerAssets($view)
    {
        foreach ($this->depends as $name) {
            $view->registerAssetBundle($name);
        }

        $this->publish($view->getAssetManager());

        foreach ($this->js as $js)
        {
            if (strpos($js, '://') !== false)
                $view->registerJsFile($js, $this->jsOptions);
            else
                $view->registerJsFile($this->baseUrl . '/' . $js, $this->jsOptions);
        }
        
        foreach ($this->css as $css)
        {
            if (strpos($css, '://') !== false)
                $view->registerCssFile($css, $this->cssOptions);
            else
                $view->registerCssFile($this->baseUrl . '/' . $css, $this->cssOptions);
        }
    }
}