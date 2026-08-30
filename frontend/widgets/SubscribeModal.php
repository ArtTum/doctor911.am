<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/11/2018
 * Time: 6:37 PM
 */
namespace frontend\widgets;


use common\components\Helper;
use common\components\Translate;
use common\models\Doctor;
use common\models\Hospital;
use common\models\Subscribe;
use Yii;
use yii\base\Widget;

class SubscribeModal extends Widget {

    public function init() {
        parent::init();
    }

    /**
     * @return string
     */
    public function run() {
        $model = new Subscribe();
        $alias = Yii::$app->request->get('alias');

        $doctor = Doctor::findOne(['alias' => $alias]);
        $hospital = Hospital::findOne(['alias' => $alias]);

        if(!empty($doctor)){
            $doctor_name = Translate::text($doctor->getLangHasDoctors(), 'full_name');
        }else{
            $doctor_name = null;
        }

        if(!empty($hospital)){
            $hospital_name = Translate::text($hospital->getLangHasHospitals(), 'name');
        }else{
            $hospital_name = null;
        }

        return $this->render('subscribe-modal', [
            'model' => $model,
            'doctor_name' => $doctor_name,
            'hospital_name' => $hospital_name,
        ]);
    }
}
