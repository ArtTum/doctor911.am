<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'vendors/custom/fullcalendar/fullcalendar.bundle.css',
        'vendors/base/vendors.bundle.css',
        'demo/default/base/style.bundle.css',
        'css/site.css'
    ];
    public $js = [
        'js/select2.full.js',
        'js/bootstrap-filestyle.min.js',
        'demo/default/base/scripts.bundle1.js',
        'demo/default/custom/components/forms/widgets/select2.js',
        'js/multiselect.js',
        'js/js-fileupload.js',
        'js/jquery.slimscroll.min.js',
        'js/main2.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
      //  'yii\bootstrap\BootstrapAsset',
    ];
}
