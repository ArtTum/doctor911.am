<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_type".
 *
 * @property int $lang_id
 * @property int $type_id
 * @property string $name
 *
 * @property Lang $lang
 * @property Type $type
 *
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_description
 */
class LangHasType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'type_id', 'name'], 'required'],
            [['lang_id', 'type_id'], 'integer'],
            [['meta_description'], 'string'],
            [['name', 'meta_title', 'meta_keys'], 'string', 'max' => 255],
            [['lang_id', 'type_id'], 'unique', 'targetAttribute' => ['lang_id', 'type_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'type_id' => Yii::t('admin', 'Type ID'),
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
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * @param $post
     * @param $lang
     * @param $model_id
     */
    public function add($post, $lang, $model_id){

        foreach($lang as $item){
            $model = new LangHasType();
            $model->lang_id = $item->id;
            $model->type_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
            $model->meta_title = $post['lang']['meta_title_'.$item->id];
            $model->meta_keys = $post['lang']['meta_keys_'.$item->id];
            $model->meta_description = $post['lang']['meta_description_'.$item->id];
            $model->save();
        }
    }

    /**
     * @param $model_id
     */
    public function remove($model_id){
        LangHasType::deleteAll(['type_id' => $model_id]);
    }
}