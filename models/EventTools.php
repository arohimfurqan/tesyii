<?php

namespace app\models;

use Yii;
// use  yii\base\Model;


/**
 * This is the model class for table "event_tools".
 *
 * @property int $id
 * @property int|null $event_id
 * @property string|null $nama_event
 * @property int|null $quantity
 *
 * @property Event $event
 */
class EventTools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_tools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'quantity'], 'integer'],
            [['nama_event'], 'string', 'max' => 255],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'nama_event' => 'Nama Event',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
