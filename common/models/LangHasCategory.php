<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang_has_category".
 *
 * @property int $lang_id
 * @property int $category_id
 * @property string $name
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_description
 *
 * @property Category $category
 * @property Lang $lang
 */
class LangHasCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang_has_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'category_id', 'name'], 'required'],
            [['lang_id', 'category_id'], 'integer'],
            [['meta_description'], 'string'],
            [['name', 'meta_title', 'meta_keys'], 'string', 'max' => 255],
            [['lang_id', 'category_id'], 'unique', 'targetAttribute' => ['lang_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => Yii::t('admin', 'Category ID'),
            'name' => Yii::t('admin', 'Name'),
            'meta_title' => Yii::t('admin', 'Meta Title'),
            'meta_keys' => Yii::t('admin', 'Meta Keys'),
            'meta_description' => Yii::t('admin', 'Meta Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
            $model = new LangHasCategory();
            $model->lang_id = $item->id;
            $model->category_id = $model_id;
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
        LangHasCategory::deleteAll(['category_id' => $model_id]);
    }
}
