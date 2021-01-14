<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<div class="modeluser-form">
    <h2>Sign Up</h2>
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>