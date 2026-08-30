<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $url
 * @property int $status
 * @property int $order
 *
 * @property LangHasMenu[] $langHasMenus
 * @property Lang[] $langs
 * @property SubMenu[] $subMenus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
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
    public function getLangHasMenus()
    {
        return $this->hasMany(LangHasMenu::className(), ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_menu', ['menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubMenus()
    {
        return $this->hasMany(SubMenu::className(), ['menu_id' => 'id']);
    }
}
