<?php

namespace common\models;

use common\components\Helper;
use Yii;

/**
 * This is the model class for table "lang_has_library".
 *
 * @property int $lang_id
 * @property int $library_id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_description
 *
 * @property Lang $lang
 * @property Library $library
 */
class LangHasLibrary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_library';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'library_id', 'name'], 'required'],
            [['lang_id', 'library_id'], 'integer'],
            [['description', 'meta_description'], 'string'],
            [['name', 'meta_title', 'meta_keys'], 'string', 'max' => 255],
            [['lang_id', 'library_id'], 'unique', 'targetAttribute' => ['lang_id', 'library_id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['library_id'], 'exist', 'skipOnError' => true, 'targetClass' => Library::className(), 'targetAttribute' => ['library_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => Yii::t('admin', 'Lang ID'),
            'library_id' => Yii::t('admin', 'Library ID'),
            'name' => Yii::t('admin', 'Name'),
            'description' => Yii::t('admin', 'Description'),
            'meta_title' => Yii::t('admin', 'Meta Title'),
            'meta_keys' => Yii::t('admin', 'Meta Keys'),
            'meta_description' => Yii::t('admin', 'Meta Description'),
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
    public function getLibrary()
    {
        return $this->hasOne(Library::className(), ['id' => 'library_id']);
    }

    /**
     * @param $post
     * @param $lang
     * @param $model_id
     */
    public function add($post, $lang, $model_id){

        foreach($lang as $item){
            $model = new LangHasLibrary();
            $model->lang_id = $item->id;
            $model->library_id = $model_id;
            $model->name = $post['lang']['name_'.$item->id];
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
        LangHasLibrary::deleteAll(['library_id' => $model_id]);
    }
}
