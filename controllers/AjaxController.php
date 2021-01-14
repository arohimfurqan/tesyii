<?php

namespace app\controllers;

use app\models\Modelbook;

class AjaxController extends \yii\web\Controller
{

    public function getBooks()
    {
        // $books = [
        //     ['id' => '1', 'title' => 'Pemrograman PHP', 'author' => 'Hafid', 'year' => '2015'],
        //     ['id' => '2', 'title' => 'Pemrograman JS', 'author' => 'Juned', 'year' => '2014'],
        //     ['id' => '3', 'title' => 'Database MySQL', 'author' => 'Lily', 'year' => '2013'],
        // ];
        // Jika menggunakan basis data maka:
        $books = Modelbook::find()->asArray()->orderBy(['nama_buku' => SORT_ASC])->all();
        return $books;
    }

    public function actionBook()
    {
        $model = new \yii\base\DynamicModel([
            'nama_buku', 'penerbit', 'tahun_terbit'
        ]);
        $model->addRule(['nama_buku'], 'string');
        $model->addRule(['penerbit'], 'string');
        $model->addRule(['tahun_terbit'], 'integer');

        return $this->render('book', [
            'model' => $model,
            'books' => $this->getBooks(),
        ]);
    }


    public function actionGetBook($id_buku)
    {
        $books = $this->getBooks();
        $bookSelected = [];
        foreach ($books as $book) {
            if ($book['id_buku'] == $id_buku) {
                $bookSelected = $book;
            }
        }
        // $bookSelected = Book::findOne($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'book' => $bookSelected,
        ];
    }

    public function getProvinces()
    {
        return (new \yii\db\Query())
            ->select('*')
            ->from('provinsi')
            ->orderBy(['provinsi_nama' => SORT_DESC])
            ->all(\yii::$app->db);
    }

    public function actionProvinsi()
    {
        $model = new \yii\base\DynamicModel([
            'provinsi_id', 'id_kota',
        ]);
        $model->addRule(['provinsi_id'], 'integer');
        $model->addRule(['id_kota'], 'integer');

        return $this->render('provinsi', [
            'model' => $model,
            'provinsi' => $this->getProvinces(),
        ]);
    }

    public function actionGetCities($province_id)
    {
        $cities = (new \yii\db\Query())
            ->select('*')
            ->from('kota')
            ->where([
                'id_provinsi' => $province_id,
            ])
            ->all(\yii::$app->db);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'kota' => $cities,
        ];
    }
}
