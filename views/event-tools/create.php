<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EventTools */

$this->title = 'Create Event Tools';
$this->params['breadcrumbs'][] = ['label' => 'Event Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-tools-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
