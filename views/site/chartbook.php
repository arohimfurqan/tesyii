<?php

use miloschuman\highcharts\Highcharts;

echo Highcharts::widget([
    'options' => [
        'chart' => ['type' => 'column'],
        'title' => ['text' => 'Framework'],
        'xAxis' => [
            'categories' => $years
        ],
        'yAxis' => [
            'title' => ['text' => 'Usage (thousand)']
        ],
        'series' => $series,
        'plotOptions' => [
            'column' => [
                'dataLabels' => [
                    'enabled' => true,
                ],
            ],
        ],
    ],
]);
?>

