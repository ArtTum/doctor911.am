<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctor_has_category".
 *
 * @property int $doctor_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Doctor $doctor
 */
class DoctorHasCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor_has_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'category_id'], 'required'],
            [['doctor_id', 'category_id'], 'integer'],
            [['doctor_id', 'category_id'], 'unique', 'targetAttribute' => ['doctor_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
            'category_id' => Yii::t('admin', 'Category ID'),
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
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * @param $category_id
     * @param $doctor_id
     */
    public  function add($category_id, $doctor_id){

        if(!empty($category_id)){
            foreach($category_id as $id){
                $model = new DoctorHasCategory();
                $model->doctor_id = $doctor_id;
                $model->category_id = $id;
                $model->save();
            }
        }
    }


    /**
     * @param $doctor_id
     */
    public  function remove($doctor_id){
        DoctorHasCategory::deleteAll(['doctor_id' => $doctor_id]);
    }
}
