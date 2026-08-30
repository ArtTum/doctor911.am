<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "type".
 *
 * @property int $id
 * @property string $alias
 * @property int $status
 *
 * @property HospitalHasType[] $hospitalHasTypes
 * @property Hospital[] $hospitals
 * @property LangHasType[] $langHasTypes
 * @property Lang[] $langs
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    public $name_alias;


    public function behaviors()
    {
        return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'name_alias',
                'out_attribute' => 'alias',
                'translit' => true
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'status'], 'required'],
            [['status'], 'integer'],
            [['alias','description_hide', 'keys_hide'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'alias' => Yii::t('admin', 'Alias'),
            'status' => Yii::t('admin', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitalHasTypes()
    {
        return $this->hasMany(HospitalHasType::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitals()
    {
        return $this->hasMany(Hospital::className(), ['id' => 'hospital_id'])->viaTable('hospital_has_type', ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasTypes()
    {
        return $this->hasMany(LangHasType::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('lang_has_type', ['type_id' => 'id']);
    }
}
