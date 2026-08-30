<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property string $alias
 * @property string $image
 * @property int $status
 * @property string $map
 * @property string $sale
 * @property int $plastic_surgeon
 *
 * @property Comment[] $comments
 * @property DoctorHasCategory[] $doctorHasCategories
 * @property Category[] $categories
 * @property DoctorHasLibrary[] $doctorHasLibraries
 * @property Library[] $libraries
 * @property Galery[] $galeries
 * @property GaleryCategoryHasDoctor[] $galeryCategoryHasDoctors
 * @property HospitalHasDoctor[] $hospitalHasDoctors
 * @property Hospital[] $hospitals
 * @property LangHasDoctor[] $langHasDoctors
 * @property Lang[] $langs
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
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
            [['status', 'plastic_surgeon'], 'integer'],
            [['map'], 'string'],
            [['alias','sale', 'image'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'image' => Yii::t('admin', 'Image'),
            'status' => Yii::t('admin', 'Status'),
            'map' => Yii::t('admin', 'Map'),
            'sale' => Yii::t('admin', 'Sale'),
            'plastic_surgeon' => Yii::t('admin', 'Plastic Surgeon'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorHasCategories()
    {
        return $this->hasMany(DoctorHasCategory::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('doctor_has_category', ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitalHasDoctors()
    {
        return $this->hasMany(HospitalHasDoctor::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitals()
    {
        return $this->hasMany(Hospital::className(), ['id' => 'hospital_id'])->viaTable('hospital_has_doctor', ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasDoctors()
    {
        return $this->hasMany(LangHasDoctor::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_doctor', ['doctor_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGaleries()
    {
        return $this->hasMany(Galery::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGaleryCategoryHasDoctors()
    {
        return $this->hasMany(GaleryCategoryHasDoctor::className(), ['doctor_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorHasLibraries()
    {
        return $this->hasMany(DoctorHasLibrary::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibraries()
    {
        return $this->hasMany(Library::className(), ['id' => 'library_id'])->viaTable('doctor_has_library', ['doctor_id' => 'id']);
    }


}
