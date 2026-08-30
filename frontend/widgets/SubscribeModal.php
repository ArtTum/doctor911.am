<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/11/2018
 * Time: 6:37 PM
 */
namespace frontend\widgets;


use common\models\Doctor;
use common\models\Hospital;
use frontend\models\SubscribeForm;
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
        $model = new SubscribeForm();
        $model->form_token = SubscribeForm::createFormToken();
        $alias = Yii::$app->request->get('alias');

        $doctor = Doctor::findOne(['alias' => $alias, 'status' => 1]);
        $hospital = Hospital::findOne(['alias' => $alias, 'status' => 1]);

        if(!empty($doctor)){
            $doctor_id = $doctor->id;
        }else{
            $doctor_id = null;
        }

        if(!empty($hospital)){
            $hospital_id = $hospital->id;
        }else{
            $hospital_id = null;
        }

        return $this->render('subscribe-modal', [
            'model' => $model,
            'doctor_id' => $doctor_id,
            'hospital_id' => $hospital_id,
        ]);
    }
}
