<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "footer_menu".
 *
 * @property int $id
 * @property string $url
 * @property int $status
 * @property int $order
 *
 * @property LangHasFooterMenu[] $langHasFooterMenus
 * @property Lang[] $langs
 */
class FooterMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'footer_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['status', 'order'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'url' => Yii::t('admin', 'Url'),
            'status' => Yii::t('admin', 'Status'),
            'order' => Yii::t('admin', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasFooterMenus()
    {
        return $this->hasMany(LangHasFooterMenu::className(), ['footer_menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_footer_menu', ['footer_menu_id' => 'id']);
    }
}
