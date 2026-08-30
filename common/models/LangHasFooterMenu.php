<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_footer_menu".
 *
 * @property int $lang_id
 * @property int $footer_menu_id
 * @property string $name
 *
 * @property FooterMenu $footerMenu
 * @property Lang $lang
 */
class LangHasFooterMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_footer_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'footer_menu_id', 'name'], 'required'],
            [['lang_id', 'footer_menu_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lang_id', 'footer_menu_id'], 'unique', 'targetAttribute' => ['lang_id', 'footer_menu_id']],
            [['footer_menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => FooterMenu::className(), 'targetAttribute' => ['footer_menu_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'footer_menu_id' => Yii::t('admin', 'Footer Menu ID'),
            'name' => Yii::t('admin', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooterMenu()
    {
        return $this->hasOne(FooterMenu::className(), ['id' => 'footer_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @param $post
     * @param $lang
     * @param $model_id
     */
    public function add($post, $lang, $model_id){

        foreach($lang as $item){
            $model = new LangHasFooterMenu();
            $model->lang_id = $item->id;
            $model->footer_menu_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
            $model->save();
        }
    }

    /**
     * @param $model_id
     */
    public function remove($model_id){
        LangHasFooterMenu::deleteAll(['footer_menu_id' => $model_id]);
    }
}
