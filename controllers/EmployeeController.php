<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use \app\models\Modelemployee;


class EmployeeController extends Controller
{


    public function actionIndex()
    {

        $employees = Modelemployee::find();

        $count = $employees->count();

        $pagination = new \yii\data\Pagination([
            'totalCount' => $count,
            'defaultPageSize' => 5,
        ]);

        $employeess = $employees->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('view', [
            'employees' => $employeess,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $model = new Modelemployee();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            } else {
                Yii::$app->session->setFlash('error', 'Data gagal disimpan');
            }
            return $this->refresh();
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = Modelemployee::findOne($id);

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            } else {
                Yii::$app->session->setFlash('error', 'Data gagal disimpan');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('formupdate', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = Modelemployee::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    function actionSorting()
    {
        $query = Modelemployee::find();
        $employees = $query->orderBy([
            'name' => SORT_DESC,
            'age' => SORT_DESC,
        ])
            ->all();

        return $this->render('sorting', [
            'employees' => $employees,
        ]);
    }
}
