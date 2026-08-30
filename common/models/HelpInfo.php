<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "help_info".
 *
 * @property int $id
 * @property string $image
 * @property int $order
 * @property int $status
 *
 * @property LangHasHelpInfo[] $langHasHelpInfos
 * @property Lang[] $langs
 */
class HelpInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'help_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['order', 'status'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'image' => Yii::t('admin', 'Image'),
            'order' => Yii::t('admin', 'Order'),
            'status' => Yii::t('admin', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasHelpInfos()
    {
        return $this->hasMany(LangHasHelpInfo::className(), ['help_info_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_help_info', ['help_info_id' => 'id']);
    }
}
