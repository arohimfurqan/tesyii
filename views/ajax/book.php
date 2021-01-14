<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$form = ActiveForm::begin();
$data = ArrayHelper::map($books, 'id_buku', 'nama_buku');
echo $form->field($model, 'nama_buku')->dropDownList($data, [
    'prompt' => '-Pilih Nama Buku-',
]);
echo $form->field($model, 'penerbit')->textInput();
echo $form->field($model, 'tahun_terbit')->textInput();
ActiveForm::end();


$this->registerJs('

    $("#dynamicmodel-nama_buku").change(function() {
        $.get("' . Url::to(['get-book', 'id_buku' => '']) . '" + $(this).val(), function(data) {
              $("#dynamicmodel-penerbit").val(data.book.penerbit);
              $("#dynamicmodel-tahun_terbit").val(data.book.tahun_terbit);
        });
    });

');
