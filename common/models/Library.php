<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "library".
 *
 * @property int $id
 * @property string $alias
 * @property int $status
 *
 * @property DoctorHasLibrary[] $doctorHasLibraries
 * @property Doctor[] $doctors
 * @property LangHasLibrary[] $langHasLibraries
 * @property Lang[] $langs
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'library';
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
           // [['alias'], 'required'],
            [['status'], 'integer'],
            [['alias'], 'string', 'max' => 255],
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
            'status' => Yii::t('admin', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasLibraries()
    {
        return $this->hasMany(LangHasLibrary::className(), ['library_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_library', ['library_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorHasLibraries()
    {
        return $this->hasMany(DoctorHasLibrary::className(), ['library_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['id' => 'doctor_id'])->viaTable('doctor_has_library', ['library_id' => 'id']);
    }

}
