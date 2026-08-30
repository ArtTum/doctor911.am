<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "galery_category_has_lang".
 *
 * @property int $galery_category_id
 * @property int $lang_id
 * @property string $name
 *
 * @property GaleryCategory $galeryCategory
 * @property Lang $lang
 */
class GaleryCategoryHasLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galery_category_has_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['galery_category_id', 'lang_id', 'name'], 'required'],
            [['galery_category_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['galery_category_id', 'lang_id'], 'unique', 'targetAttribute' => ['galery_category_id', 'lang_id']],
            [['galery_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GaleryCategory::className(), 'targetAttribute' => ['galery_category_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'galery_category_id' => Yii::t('admin', 'Galery Category ID'),
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'name' => Yii::t('admin', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGaleryCategory()
    {
        return $this->hasOne(GaleryCategory::className(), ['id' => 'galery_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }
}
