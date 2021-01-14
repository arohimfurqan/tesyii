<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'start',
            'end',
            'location',
        ],
    ]) ?>

    <h1>Tools</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modelsTools as $indexTools => $modelTools) : ?>
                <tr>
                    <td><?= $modelTools->nama_event ?></td>
                    <td><?= $modelTools->quantity ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>