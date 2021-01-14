<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $city_id
 * @property int|null $province_id
 * @property string|null $city_name
 * @property string|null $type
 * @property string|null $postal_code
 *
 * @property Province $province
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['city_id', 'province_id'], 'integer'],
            [['type'], 'string'],
            [['city_name'], 'string', 'max' => 255],
            [['postal_code'], 'string', 'max' => 10],
            [['city_id'], 'unique'],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'province_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City ID',
            'province_id' => 'Province ID',
            'city_name' => 'City Name',
            'type' => 'Type',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_id' => 'province_id']);
    }
}
