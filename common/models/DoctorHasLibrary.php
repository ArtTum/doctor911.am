<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_has_library".
 *
 * @property int $doctor_id
 * @property int $library_id
 *
 * @property Doctor $doctor
 * @property Library $library
 */
class DoctorHasLibrary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor_has_library';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'library_id'], 'required'],
            [['doctor_id', 'library_id'], 'integer'],
            [['doctor_id', 'library_id'], 'unique', 'targetAttribute' => ['doctor_id', 'library_id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['library_id'], 'exist', 'skipOnError' => true, 'targetClass' => Library::className(), 'targetAttribute' => ['library_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
            'library_id' => Yii::t('admin', 'Library ID'),
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
    public function getLibrary()
    {
        return $this->hasOne(Library::className(), ['id' => 'library_id']);
    }

    /**
     * @param $library_id
     * @param $doctor_id
     */
    public function add($library_id, $doctor_id){

        if(!empty($library_id)){
            foreach($library_id as $id){
                $modelLibery = new DoctorHasLibrary();
                $modelLibery->library_id = $id;
                $modelLibery->doctor_id = $doctor_id;
                $modelLibery->save();
            }
        }
    }

    /**
     * @param $doctor_id
     */
    public function remove($doctor_id){
        DoctorHasLibrary::deleteAll(['doctor_id' => $doctor_id]);
    }
}
