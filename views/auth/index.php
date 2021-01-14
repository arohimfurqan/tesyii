<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authorization';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'username',

            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            [
                'header' => 'Auth',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        "<i class='glyphicon glyphicon-lock'></i>",
                        ['view', 'id' => $model->id],
                        ['class' => 'btn btn-danger btn-xs']
                    );
                }
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>