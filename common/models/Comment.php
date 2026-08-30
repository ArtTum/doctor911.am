<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $text
 * @property int $star
 * @property int $status
 * @property int $hospital_id
 * @property int $doctor_id
 *
 * @property Doctor $doctor
 * @property Hospital $hospital
 * @property string $created
 * @property string $updated
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['text'], 'string'],
            ['star', 'number'],
            [['created', 'updated'], 'safe'],
            [['hospital_id', 'doctor_id', 'status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 45],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['hospital_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hospital::className(), 'targetAttribute' => ['hospital_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'first_name' => Yii::t('admin', 'First Name'),
            'last_name' => Yii::t('admin', 'Last Name'),
            'phone' => Yii::t('admin', 'Phone'),
            'text' => Yii::t('admin', 'Text'),
            'star' => Yii::t('admin', 'Star'),
            'hospital_id' => Yii::t('admin', 'Hospital ID'),
            'doctor_id' => Yii::t('admin', 'Doctor ID'),
            'hospital.alias' => Yii::t('admin', 'Hospital ID'),
            'doctor.alias' => Yii::t('admin', 'Doctor ID'),
            'status' => Yii::t('admin', 'Status'),
            'created' => Yii::t('admin', 'Created'),

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
    public function getHospital()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hospital_id']);
    }
}
