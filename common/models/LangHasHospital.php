<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_hospital".
 *
 * @property int $lang_id
 * @property int $hospital_id
 * @property string $name
 * @property string $tiny_text
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_description
 *
 * @property Hospital $hospital
 * @property Lang $lang
 */
class LangHasHospital extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_hospital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'hospital_id', 'name', 'tiny_text'], 'required'],
            [['lang_id', 'hospital_id'], 'integer'],
            [['tiny_text', 'description', 'meta_description'], 'string'],
            [['name', 'meta_title', 'meta_keys'], 'string', 'max' => 255],
            [['lang_id', 'hospital_id'], 'unique', 'targetAttribute' => ['lang_id', 'hospital_id']],
            [['hospital_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hospital::className(), 'targetAttribute' => ['hospital_id' => 'id']],
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
            'hospital_id' => Yii::t('admin', 'Hospital ID'),
            'name' => Yii::t('admin', 'Name'),
            'tiny_text' => Yii::t('admin', 'Tiny Text'),
            'description' => Yii::t('admin', 'Description'),
            'meta_title' => Yii::t('admin', 'Meta Title'),
            'meta_keys' => Yii::t('admin', 'Meta Keys'),
            'meta_description' => Yii::t('admin', 'Meta Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospital()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hospital_id']);
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
            $model = new LangHasHospital();
            $model->lang_id = $item->id;
            $model->hospital_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
            $model->tiny_text = $post['lang']['tiny_text_'.$item->id];
            $model->description = $post['lang']['description_'.$item->id];
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
        LangHasHospital::deleteAll(['hospital_id' => $model_id]);
    }
}
