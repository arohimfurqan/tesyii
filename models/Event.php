<?php

namespace app\models;

use Yii;



/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $start
 * @property string|null $end
 * @property string|null $location
 *
 * @property EventTools[] $eventTools
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start', 'end'], 'safe'],
            [['title', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'start' => 'Start',
            'end' => 'End',
            'location' => 'Location',
        ];
    }

    /**
     * Gets query for [[EventTools]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventTools()
    {
        return $this->hasMany(EventTools::className(), ['event_id' => 'id']);
    }
}
