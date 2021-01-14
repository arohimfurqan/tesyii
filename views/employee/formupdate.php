<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-6">
        <h1>Update Data Karyawan</h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'age') ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>