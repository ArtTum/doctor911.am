<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "social".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property int $order
 */
class Social extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url', 'icon'], 'required'],
            [['order'], 'integer'],
            [['name', 'url', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'name' => Yii::t('admin', 'Name'),
            'url' => Yii::t('admin', 'Url'),
            'icon' => Yii::t('admin', 'Icon'),
            'order' => Yii::t('admin', 'Order'),
        ];
    }
}
