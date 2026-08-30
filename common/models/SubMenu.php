<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sub_menu".
 *
 * @property int $id
 * @property string $url
 * @property int $status
 * @property int $order
 * @property int $menu_id
 *
 * @property LangHasSubMenu[] $langHasSubMenus
 * @property Lang[] $langs
 * @property Menu $menu
 */
class SubMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['status', 'order', 'menu_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['id', 'menu_id'], 'unique', 'targetAttribute' => ['id', 'menu_id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
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
            'menu_id' => Yii::t('admin', 'Menu ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasSubMenus()
    {
        return $this->hasMany(LangHasSubMenu::className(), ['sub_menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_sub_menu', ['sub_menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}
