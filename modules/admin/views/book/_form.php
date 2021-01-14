<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Modelbook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modelbook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo '<label>Check Issue Date</label>';
    echo DatePicker::widget([
        'name' => 'check_issue_date',
        'value' => date('d-M-Y', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select issue date ...'],
        'pluginOptions' => [
            'format' => 'dd-M-yyyy',
            'todayHighlight' => true
        ]
    ]);
    ?>

    <?= $form->field($model, 'nama_buku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penerbit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun_terbit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>