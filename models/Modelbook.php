<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;



/**
 * This is the model class for table "tb_book".
 *
 * @property int $id_buku
 * @property string $nama_buku
 * @property string $penerbit
 * @property int $tahun_terbit
 */
class Modelbook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_buku', 'penerbit', 'tahun_terbit'], 'required'],
            [['tahun_terbit'], 'integer'],
            [['nama_buku', 'penerbit'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_buku' => 'Id Buku',
            'nama_buku' => 'Nama Buku',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }
}
