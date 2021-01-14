<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'pjax-form', 'timeout' => false,
]);
?>
<?php
if (Yii::$app->request->isAjax)
    echo \app\widgets\Alert::widget();
?>

<?php $form = ActiveForm::begin([
    'options' => ['data-pjax' => true]
]); ?>
<?php
/* @var $this yii\web\View */
/* @var $model app\models\Modelbook */
/* @var $form yii\widgets\ActiveForm */


// $this->registerJsFile('@web/js/main.js', [
// 'depends' => [
// \yii\web\JqueryAsset::className()
// ]
// ]);

// $this->registerCssFile("@web/css/print.css", [
// 'depends' => [
// yii\bootstrap\BootstrapAsset::className()
// ],
// 'media' => 'print',
// ], 'css-print-theme');


//
?>

<div class="modelbook-form">


    <?= $form->field($model, 'nama_buku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penerbit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun_terbit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a('Close', ['index'], [
            'class' => 'btn btn-success',
            'onclick' => '
      $("#bookModal").modal("hide");
      return false;
    '
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php
    $this->registerJs('
$("#pjax-form").on("pjax:end", function() {
    $.pjax.reload("#pjax-gridview",{
        "timeout": false,
        "url": "' . \yii\helpers\Url::to(['index']) . '",
        "replace": false,
    });
});
');
    ?>

    <?php Pjax::end(); ?>
</div>