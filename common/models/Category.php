<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $alias
 * @property string $image
 * @property int $status
 * @property int $order
 *
 * @property DoctorHasCategory[] $doctorHasCategories
 * @property Doctor[] $doctors
 * @property LangHasCategory[] $langHasCategories
 * @property Lang[] $langs
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
          //  [['alias', 'image'], 'required'],
            [['status', 'order'], 'integer'],
            [['alias', 'image'], 'string', 'max' => 255],
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
            'order' => Yii::t('admin', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctorHasCategories()
    {
        return $this->hasMany(DoctorHasCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['id' => 'doctor_id'])->viaTable('doctor_has_category', ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasCategories()
    {
        return $this->hasMany(LangHasCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_category', ['category_id' => 'id']);
    }
}
