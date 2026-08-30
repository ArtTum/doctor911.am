<?php

namespace common\models;

use common\components\Helper;
use Yii;

/**
 * This is the model class for table "lang_has_doctor".
 *
 * @property int $lang_id
 * @property int $doctor_id
 * @property string $full_name
 * @property string $doctor_info
 * @property string $tiny_text
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_description
 *
 * @property Doctor $doctor
 * @property Lang $lang
 */
class LangHasDoctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'doctor_id', 'full_name'], 'required'],
            [['lang_id', 'doctor_id'], 'integer'],
            [['tiny_text', 'description', 'meta_description'], 'string'],
            [['full_name', 'doctor_info', 'meta_title', 'meta_keys'], 'string', 'max' => 255],
            [['lang_id', 'doctor_id'], 'unique', 'targetAttribute' => ['lang_id', 'doctor_id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
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
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
            'full_name' => Yii::t('admin', 'Full Name'),
            'doctor_info' => Yii::t('admin', 'Doctor Info'),
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
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
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
            $model = new LangHasDoctor();
            $model->lang_id = $item->id;
            $model->doctor_id = $model_id;
            $model->full_name = $post['lang']['full_name_'.$item->id];
            $model->doctor_info = $post['lang']['doctor_info_'.$item->id];
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
        LangHasDoctor::deleteAll(['doctor_id' => $model_id]);
    }
}
