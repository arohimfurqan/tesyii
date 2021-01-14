<?php

use PharIo\Manifest\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
// use yii\helpers\Url;
?>
<h1>Gallery</h1>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]) ?>

<?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'class' => 'form-control', 'accept' => 'image/*']) ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
foreach ($model3 as $file) {
    // echo Html::img(Yii::getAlias('@app') . '/uploads/' . $file->images, [
    //     'class' => 'img-thumbnail', 'style' => 'float:left;width:150px;'
    // ]);

    $url = Yii::getAlias('@web') . '/uploads/' . $file->images;
    echo Html::a(Html::img($url, [
        'class' => 'img-thumbnail', 'style' => 'float:left;width:150px;'
    ]), $url, ['target' => '_blank']);

    // $url = Yii::getAlias('@app') . '/uploads/' . $file->images;
    // echo Html::a('View', ['download', 'inline' => true], ['target' => '_blank']);
    // Html::img(['download', 'inline' => true], [
    //     'class' => 'img-thumbnail', 'style' => 'float:right;'
    // ]);
}
