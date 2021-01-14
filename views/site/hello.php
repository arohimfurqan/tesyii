<?php

use \yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<h1>Komentar</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'nama') ?>
<?= $form->field($model, 'pesan') ?>
<?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>


<!-- 
<h1>Komentar</h1>
<form action="/basic/web/index.php?r=site/komentar" method="post" role="form">
    <input type="hidden" name="_csrf" value="<?= Html::csrfMetaTags() ?>">
    <div class="form-group field-komentar-nama required">
        <label class="control-label" for="komentar-nama">Nama</label>
        <input type="text" id="komentar-nama" class="form-control" name="Komentar[nama]">
        <p class="help-block help-block-error"></p>
    </div>
    <div class="form-group field-komentar-pesan required">
        <label class="control-label" for="komentar-pesan">Pesan</label>
        <input type="text" id="komentar-pesan" class="form-control" name="Komentar[pesan]">
        <p class="help-block help-block-error"></p>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form> -->