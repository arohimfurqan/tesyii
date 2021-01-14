<?php

namespace app\models;

use yii\db\ActiveRecord;

class Modelemployee extends ActiveRecord
{
    public static function tableName()
    {
        return 'employee';
    }



    public function rules()
    {
        return [
            [['name', 'age'], 'required'],
            [['name'], 'string'],
            [['age'], 'integer'],
        ];
    }
}
