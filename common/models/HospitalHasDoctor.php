<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hospital_has_doctor".
 *
 * @property int $hospital_id
 * @property int $doctor_id
 *
 * @property Doctor $doctor
 * @property Hospital $hospital
 */
class HospitalHasDoctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital_has_doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospital_id', 'doctor_id'], 'required'],
            [['hospital_id', 'doctor_id'], 'integer'],
            [['hospital_id', 'doctor_id'], 'unique', 'targetAttribute' => ['hospital_id', 'doctor_id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['hospital_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hospital::className(), 'targetAttribute' => ['hospital_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospital_id' => Yii::t('admin', 'Hospital ID'),
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hospital_id']);
    }


    /**
     * @param $hospital_id
     * @param $doctor_id
     */
    public  function add($hospital_id, $doctor_id){

        if(!empty($hospital_id)){
            foreach($hospital_id as $id){
                $model = new HospitalHasDoctor();
                $model->doctor_id = $doctor_id;
                $model->hospital_id = $id;
                $model->save();
            }
        }
    }


    /**
     * @param $doctor_id
     */
    public  function remove($doctor_id){
        HospitalHasDoctor::deleteAll(['doctor_id' => $doctor_id]);
    }
}
