<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "galery".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property int $doctor_id
 * @property int $order
 *
 * @property Doctor $doctor
 */
class Galery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id'], 'required'],
            [['doctor_id', 'order'], 'integer'],
            [['path', 'name'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'path' => Yii::t('admin', 'Path'),
            'name' => Yii::t('admin', 'Name'),
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
}
