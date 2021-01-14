<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_social_media".
 *
 * @property string $id
 * @property string|null $username
 * @property int|null $user_id
 * @property string|null $social_media
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class UserSocialMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_social_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['social_media'], 'string'],
            [['id', 'username'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'user_id' => 'User ID',
            'social_media' => 'Social Media',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
