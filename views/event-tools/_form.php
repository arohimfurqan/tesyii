<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventTools */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-tools-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->textInput() ?>

    <?= $form->field($model, 'nama_event')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
