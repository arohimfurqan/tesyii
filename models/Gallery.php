<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $user_id
 * @property string|null $images
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['images'], 'file', 'extensions' => ['png', 'jpg', 'jpeg'], 'maxFiles' => 3, 'mimeTypes' => 'image/jpeg, image/png',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'images' => 'Images',
        ];
    }
}
