<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\filters\auth\QueryParamAuth;
use \app\components\CustomAuth;

class ProvinceRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'tokenParam' => 'key',
        ];
        return $behaviors;
    }



    protected function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

    public function actionIndex()
    {
        $provinces = \app\models\Province::find()->all();
        return [
            'results' => $provinces,
        ];
    }
}
