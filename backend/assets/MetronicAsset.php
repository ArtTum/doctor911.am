<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 10/24/2017
 * Time: 11:40 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;

class MetronicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'vendors/custom/fullcalendar/fullcalendar.bundle.css',
        'vendors/base/vendors.bundle.css',
        'demo/default/base/style.bundle.css',
        'css/site.css'
    ];
    public $js = [
     //   'vendors/base/vendors.bundle.js',
        'demo/default/base/scripts.bundle1.js',
        'vendors/custom/fullcalendar/fullcalendar.bundle.js',
        'app/js/dashboard.js',
        'demo/default/custom/components/datatables/base/data-local.js',
        'demo/default/custom/components/forms/widgets/select2.js',
        'js/jquery.slimscroll.min.js',
        'js/script2.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
