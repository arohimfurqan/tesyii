<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EventTools */

$this->title = 'Update Event Tools: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Event Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-tools-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
