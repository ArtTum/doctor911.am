<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "galery_category".
 *
 * @property int $id
 * @property string $alias
 * @property int $status
 *
 * @property GaleryCategoryHasDoctor[] $galeryCategoryHasDoctors
 * @property GaleryCategoryHasLang[] $galeryCategoryHasLangs
 * @property Lang[] $langs
 */
class GaleryCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galery_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
    public function getGaleryCategoryHasDoctors()
    {
        return $this->hasMany(GaleryCategoryHasDoctor::className(), ['galery_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGaleryCategoryHasLangs()
    {
        return $this->hasMany(GaleryCategoryHasLang::className(), ['galery_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('galery_category_has_lang', ['galery_category_id' => 'id']);
    }
}
