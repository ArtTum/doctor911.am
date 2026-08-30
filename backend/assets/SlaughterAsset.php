<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SlaughterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/slaughter.css',
        'css/site.css'
    ];
    public $js = [
        'js/slaughter.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
