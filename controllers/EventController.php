<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\SearchEvent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EventTools;
use app\models\Tabular;
use yii\helpers\ArrayHelper;


/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchEvent();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $modelsTools = $model->eventTools;

        return $this->render('view', [
            'model' => $model,
            'modelsTools' => (empty($modelsTools)) ? [new EventTools] : $modelsTools,
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();
        $modelsTools = [new EventTools];

        if ($model->load(Yii::$app->request->post())) {
            // load data from form submit
            $modelsTools = Tabular::createMultiple(EventTools::classname());
            Tabular::loadMultiple($modelsTools, Yii::$app->request->post());
            // validasi data
            $valid = $model->validate();
            $valid = Tabular::validateMultiple($modelsTools) && $valid;
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsTools as $indexTools => $modelTools) {
                            if ($flag === false) {
                                break;
                            }
                            $modelTools->event_id = $model->id;
                            if (!($flag = $modelTools->save(false))) {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Input data sukses');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error', 'Input data gagal');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Input data gagal');
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsTools' => (empty($modelsTools)) ? [new EventTools] : $modelsTools,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsTools = $model->eventTools;
        if ($model->load(Yii::$app->request->post())) {
            $oldToolsIDs = ArrayHelper::map($modelsTools, 'id', 'id');
            $modelsTools = Tabular::createMultiple(EventTools::classname(), $modelsTools);
            Tabular::loadMultiple($modelsTools, Yii::$app->request->post());
            $deletedToolsIDs = array_diff($oldToolsIDs, array_filter(ArrayHelper::map($modelsTools, 'id', 'id')));
            // validate models
            $valid = $model->validate();
            $valid = Tabular::validateMultiple($modelsTools) && $valid;
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedToolsIDs)) {
                            EventTools::deleteAll(['id' => $deletedToolsIDs]);
                        }

                        foreach ($modelsTools as $indexTools => $modelTools) {
                            if ($flag === false) {
                                break;
                            }
                            $modelTools->event_id = $model->id;
                            if (!($flag = $modelTools->save(false))) {
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success', 'Update data sukses');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        \Yii::$app->session->setFlash('error', 'Update data gagal');
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    \Yii::$app->session->setFlash('error', 'Update data gagal');
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsTools' => (empty($modelsTools)) ? [new EventTools] : $modelsTools,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionEventCalendar($start = NULL, $end = NULL, $_ = NULL)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = \app\models\Event::find()->all();
        if (!empty($start) and !empty($end)) {
            $model = \app\models\Event::find()
                ->where(['>=', 'start', date('Y-m-d 00:00:01', strtotime($start))])
                ->andWhere(['<=', 'end', date('Y-m-d 23:59:59', strtotime($end))])
                ->all();
        }

        $events = [];
        foreach ($model as $event) {
            $events[] = [
                'title' => $event->title,
                'start' => date('Y-m-d 00:00:01', strtotime($event->start)),
                'end' => date('Y-m-d 23:59:59', strtotime($event->end)),
                //'color'=>'#CC0000',
                //'allDay'=>true,
                //'url'=>'http://anyurl.com'
            ];
        }
        return $events;
    }
}
