<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modelbook */

$this->title = 'Update Modelbook: ' . $model->id_buku;
$this->params['breadcrumbs'][] = ['label' => 'Modelbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_buku, 'url' => ['view', 'id' => $model->id_buku]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modelbook-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>



</div>