<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$form = ActiveForm::begin();
$data = ArrayHelper::map($provinsi, 'provinsi_id', 'provinsi_nama');
echo $form->field($model, 'provinsi_id')->dropDownList($data, [
    'prompt' => '-Pilih Nama Provinsi-',
]);
echo $form->field($model, 'id_kota')->dropDownList([], [
    'prompt' => '-Pilih Nama Kota-',
]);
ActiveForm::end();



$this->registerJs('

    $("#dynamicmodel-id_kota").attr("disabled",true);
    $("#dynamicmodel-provinsi_id").change(function() {
        $.get("' . Url::to(['get-cities', 'province_id' => '']) . '" + $(this).val(), function(data) {
            select = $("#dynamicmodel-id_kota")
            select.empty();
            var options = "<option value=\'\'>-Pilih Nama Kota-</option>";
            $.each(data.kota, function(key, value) {
                options += "<option value=\'"+value.id_kota+"\'>"+ value.nama_kota +"</option>";
            });
            select.append(options);
            $("#dynamicmodel-id_kota").attr("disabled",false);
        });
    });

');
