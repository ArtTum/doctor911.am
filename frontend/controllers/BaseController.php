<?php
/**
 * Created by PhpStorm.
 * User: Narek
 * Date: 2/4/2016
 * Time: 10:47
 */

namespace frontend\controllers;

use common\components\Helper;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{

    public function init() {


        Yii::$app->language = Yii::$app->request->get('language')
            ? Yii::$app->request->get('language')
            : 'am';

        parent::init();
    }
}