<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
// use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchBook */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modelbooks';
$this->params['breadcrumbs'][] = $this->title;
// echo Yii::$app->getSecurity()->generatePasswordHash('123456');
// if ((Mimin::checkRoute($this->context->id . '/create'))) {
//     echo Html::a('Create Category', ['create'], ['class' => 'btn btn-success']);
// }

?>

<div class="modelbook-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Modelbook', ['create'], [
            'class' => 'btn btn-success', 'data-toggle' => "modal",
            'data-target' => "#bookModal",
        ]) ?>
        <?= Html::a('Export Excel', ['export-excel'], ['class' => 'btn btn-info']); ?>
        <?= Html::a('Export Excel2', ['export-excel2'], ['class' => 'btn btn-warning']); ?>
        <?= Html::a('Export Word', ['export-word'], ['class' => 'btn btn-danger']); ?>
        <?= Html::a('Export PDF', ['export-pdf'], ['class' => 'btn btn-primary']); ?>

    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php Pjax::begin(['timeout' => false, 'id' => 'pjax-gridview']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'

            ],

            // 'id_buku',
            'nama_buku',
            'penerbit',
            'tahun_terbit',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $icon = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($icon, $url, [
                            'data-toggle' => "modal",
                            'data-target' => "#bookModal",
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $icon = '<span class="glyphicon glyphicon-pencil"></span>';
                        return Html::a($icon, $url, [
                            'data-toggle' => "modal",
                            'data-target' => "#bookModal",
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $icon = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($icon, $url, [
                            'class' => 'pjaxDelete',

                        ]);
                    },
                ]
            ],

        ],
    ]); ?>
    <?php
    $this->registerJs('
$(".pjaxDelete").on("click", function (e) {
    
    e.preventDefault();
    if(confirm("Are you sure you want to delete this itemns?")){
        
        $.post($(this).attr("href"), function(data) {
            
            $.pjax.reload("#pjax-gridview",{"timeout":false});
        });
    }
});

    $("#bookModal").on("shown.bs.modal", function (event) {
        var button = $(event.relatedTarget)
        var href = button.attr("href")
        $.pjax.reload("#pjax-modal",{
            "timeout":false,
            "url": href, 
            "replace": false,
        });
    });


    var currentData = "";
    var check = function(){
        setTimeout(function(){
            $.ajax({ url: "' . Url::to(['book/check']) . '", success: function(data){
                if(currentData!=data.lastId){
                    currentData = data.lastId;    
                    $.pjax({
                        url:"' . Url::to(['book/index']) . '",
                        container:"#pjax-gridview",
                        timeout:false,
                        replace: false,
                    }).done(function(data) { 
                        check();
                    });
                }
                else{
                    check();
                }
            }, dataType: "json"});
        }, 5000);
    }
    check();

');
    ?>


</div>
<?php Pjax::end(); ?>
<?php
Modal::begin([
    'id' => 'bookModal',
]);
Pjax::begin([
    'id' => 'pjax-modal', 'timeout' => false,
    'enablePushState' => false,
    'enableReplaceState' => false,
]);

Pjax::end();
Modal::end();
?>