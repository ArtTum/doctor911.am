<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $status
 * @property string $alias
 *
 * @property LangHasPage[] $langHasPages
 * @property Lang[] $langs
 */
class Page extends \yii\db\ActiveRecord
{
    public $name_alias;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

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
        //    [['alias'], 'required'],
            [['status'], 'integer'],
            [['alias'], 'string', 'max' => 255],
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
            'status' => Yii::t('admin', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasPages()
    {
        return $this->hasMany(LangHasPage::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_page', ['page_id' => 'id']);
    }
}
