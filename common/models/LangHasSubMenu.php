<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_sub_menu".
 *
 * @property int $lang_id
 * @property int $sub_menu_id
 * @property string $name
 *
 * @property Lang $lang
 * @property SubMenu $subMenu
 */
class LangHasSubMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_sub_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'sub_menu_id', 'name'], 'required'],
            [['lang_id', 'sub_menu_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lang_id', 'sub_menu_id'], 'unique', 'targetAttribute' => ['lang_id', 'sub_menu_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['sub_menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubMenu::className(), 'targetAttribute' => ['sub_menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'sub_menu_id' => Yii::t('admin', 'Sub Menu ID'),
            'name' => Yii::t('admin', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubMenu()
    {
        return $this->hasOne(SubMenu::className(), ['id' => 'sub_menu_id']);
    }

    /**
     * @param $post
     * @param $lang
     * @param $model_id
     */
    public function add($post, $lang, $model_id){

        foreach($lang as $item){
            $model = new LangHasSubMenu();
            $model->lang_id = $item->id;
            $model->sub_menu_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
            $model->save();
        }
    }

    /**
     * @param $model_id
     */
    public function remove($model_id){
        LangHasSubMenu::deleteAll(['sub_menu_id' => $model_id]);
    }
}
