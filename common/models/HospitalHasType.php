<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hospital_has_type".
 *
 * @property int $hospital_id
 * @property int $type_id
 *
 * @property Hospital $hospital
 * @property Type $type
 */
class HospitalHasType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital_has_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hospital_id', 'type_id'], 'required'],
            [['hospital_id', 'type_id'], 'integer'],
            [['hospital_id', 'type_id'], 'unique', 'targetAttribute' => ['hospital_id', 'type_id']],
            [['hospital_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hospital::className(), 'targetAttribute' => ['hospital_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hospital_id' => Yii::t('admin', 'Hospital ID'),
            'type_id' => Yii::t('admin', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hospital_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }


    /**
     * @param $type_id
     * @param $hospital_id
     */
    public  function add($type_id, $hospital_id){

        if(!empty($type_id)){
            foreach($type_id as $id){
                $model = new HospitalHasType();
                $model->type_id = $id;
                $model->hospital_id = $hospital_id;
                $model->save();
            }
        }
    }


    /**
     * @param $hospital_id
     */
    public  function remove($hospital_id){
        HospitalHasType::deleteAll(['hospital_id' => $hospital_id]);
    }
}