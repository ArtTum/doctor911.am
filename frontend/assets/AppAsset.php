<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
        'slick/slick.css',
        'slick/slick-theme.css',
        'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css',
    ];
    public $js = [
        'slick/slick.min.js',
        'js/main.js',
        'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
