<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $province_id
 * @property string|null $province
 *
 * @property City[] $cities
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id'], 'required'],
            [['province_id'], 'integer'],
            [['province'], 'string', 'max' => 255],
            [['province_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'province' => 'Province',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['province_id' => 'province_id']);
    }
}
