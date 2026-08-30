<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hospital".
 *
 * @property int $id
 * @property string $alias
 * @property int $brand
 * @property int $status
 * @property string $image
 * @property string $sale
 * @property string $map
 *
 * @property Comment[] $comments
 * @property HospitalHasDoctor[] $hospitalHasDoctors
 * @property Doctor[] $doctors
 * @property HospitalHasType[] $hospitalHasTypes
 * @property Type[] $types
 * @property LangHasHospital[] $langHasHospitals
 * @property Lang[] $langs
 */
class Hospital extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hospital';
    }

    public $name_alias;

    public function behaviors()
    {
        return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'name_alias',
                'out_attribute' => 'alias',
                'translit' => true
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'map'], 'required'],
            [['brand', 'status'], 'integer'],
            [['map', 'sale'], 'string'],
            [['alias', 'image', 'sale'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'alias' => Yii::t('admin', 'Alias'),
            'brand' => Yii::t('admin', 'Brand'),
            'status' => Yii::t('admin', 'Status'),
            'image' => Yii::t('admin', 'Image'),
            'map' => Yii::t('admin', 'Map'),
            'sale' => Yii::t('admin', 'Sale'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitalHasDoctors()
    {
        return $this->hasMany(HospitalHasDoctor::className(), ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['id' => 'doctor_id'])->viaTable('hospital_has_doctor', ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitalHasTypes()
    {
        return $this->hasMany(HospitalHasType::className(), ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['id' => 'type_id'])->viaTable('hospital_has_type', ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id'])->viaTable('hospital_has_type', ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasHospitals()
    {
        return $this->hasMany(LangHasHospital::className(), ['hospital_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_hospital', ['hospital_id' => 'id']);
    }
}
