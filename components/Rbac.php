<?php

namespace app\components;

use Yii;
use yii\filters\AccessControl;

class Rbac extends \yii\base\ActionFilter
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Anda tidak diizinkan untuk mengakses halaman ' . $action->id . ' ini!');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['action1', 'action2'],
                        'roles' => ['author'],
                    ],
                ]
            ]
        ];
    }


    public function beforeAction($action)
    {
        $actionID = $action->id;
        $user = \Yii::$app->user;
        if ($user->can('/' . $actionID)) {
            return true;
        }

        $controllerID = $action->controller->id;
        if (in_array($controllerID, ['default', 'site'])) {
            return true;
        }

        if (!$action instanceof \yii\web\ErrorAction) {
            if ($user->getIsGuest()) {
                $user->loginRequired();
            } else {
                throw new \yii\web\ForbiddenHttpException('Anda tidak diizinkan untuk mengakses halaman ' . $action->id . ' ini!');
            }
        }
    }
}
