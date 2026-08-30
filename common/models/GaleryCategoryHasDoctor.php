<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "galery_category_has_doctor".
 *
 * @property int $id
 * @property int $galery_category_id
 * @property int $doctor_id
 *
 * @property Galery[] $galeries
 * @property Doctor $doctor
 * @property GaleryCategory $galeryCategory
 */
class GaleryCategoryHasDoctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galery_category_has_doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['galery_category_id', 'doctor_id'], 'required'],
            [['galery_category_id', 'doctor_id'], 'integer'],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['galery_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GaleryCategory::className(), 'targetAttribute' => ['galery_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'galery_category_id' => Yii::t('admin', 'Galery Category ID'),
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGaleries()
    {
        return $this->hasMany(Galery::className(), ['galery_category_has_doctor_id' => 'id']);
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
    public function getGaleryCategory()
    {
        return $this->hasOne(GaleryCategory::className(), ['id' => 'galery_category_id']);
    }
}
