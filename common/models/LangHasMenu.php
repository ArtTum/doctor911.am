<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_menu".
 *
 * @property int $lang_id
 * @property int $menu_id
 * @property string $name
 *
 * @property Lang $lang
 * @property Menu $menu
 */
class LangHasMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'menu_id', 'name'], 'required'],
            [['lang_id', 'menu_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lang_id', 'menu_id'], 'unique', 'targetAttribute' => ['lang_id', 'menu_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'menu_id' => Yii::t('admin', 'Menu ID'),
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
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @param $post
     * @param $lang
     * @param $model_id
     */
    public function add($post, $lang, $model_id){

        foreach($lang as $item){
            $model = new LangHasMenu();
            $model->lang_id = $item->id;
            $model->menu_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
            $model->save();
        }
    }

    /**
     * @param $model_id
     */
    public function remove($model_id){
        LangHasMenu::deleteAll(['menu_id' => $model_id]);
    }
}
