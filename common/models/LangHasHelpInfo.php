<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_help_info".
 *
 * @property int $lang_id
 * @property int $help_info_id
 * @property string $text
 *
 * @property HelpInfo $helpInfo
 * @property Lang $lang
 */
class LangHasHelpInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_help_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'help_info_id', 'text'], 'required'],
            [['lang_id', 'help_info_id'], 'integer'],
            [['text'], 'string'],
            [['lang_id', 'help_info_id'], 'unique', 'targetAttribute' => ['lang_id', 'help_info_id']],
            [['help_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpInfo::className(), 'targetAttribute' => ['help_info_id' => 'id']],
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
            'help_info_id' => Yii::t('admin', 'Help Info ID'),
            'text' => Yii::t('admin', 'Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpInfo()
    {
        return $this->hasOne(HelpInfo::className(), ['id' => 'help_info_id']);
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
            $model = new LangHasHelpInfo();
            $model->lang_id = $item->id;
            $model->help_info_id = $model_id;
            $model->text = $post['lang']['text_'.$item->id];
            $model->save();
        }
    }

    /**
     * @param $model_id
     */
    public function remove($model_id){
        LangHasHelpInfo::deleteAll(['help_info_id' => $model_id]);
    }
}
