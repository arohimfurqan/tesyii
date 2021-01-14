<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modelbook */

$this->title = 'Create Modelbook';
$this->params['breadcrumbs'][] = ['label' => 'Modelbooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelbook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
