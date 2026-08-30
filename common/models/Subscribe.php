<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "subscribe".
 *
 * @property int $id
 * @property string $date
 * @property string $year
 * @property int $month
 * @property string $full_name
 * @property string $phone
 * @property string|null $description
 * @property string|null $doctor
 * @property string|null $hospital
 * @property int|null $status
 * @property string|null $color
 * @property string $show_status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $updated
 */
class Subscribe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'phone'], 'required'],
            [['date', 'year', 'created_at', 'updated_at', 'updated'], 'safe'],
            [['month', 'status'], 'integer'],
            [['description', 'show_status'], 'string'],
            [['full_name', 'doctor', 'hospital', 'color'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'year' => 'Year',
            'month' => 'Month',
            'status' => 'Status',
            'color' => 'Color',
            'show_status' => 'Show Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated' => 'Updated',
            'full_name' => Yii::t('frontend', 'Full Name'),
            'phone' => Yii::t('frontend', 'Phone'),
            'description' => Yii::t('frontend', 'Description'),
            'doctor' => Yii::t('frontend', 'Doctor'),
            'hospital' => Yii::t('frontend', 'Hospital'),
        ];
    }
}


