<?php

use yii\helpers\Html;
?>
<h1>Daftar Karyawan</h1>
<?php
echo Html::a('Create', ['create'], ['class' => 'btn btn-primary']);
echo "<br/>";
echo "<br/>";
echo "<table class='table table-bordered table-striped'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>NAME</th>";
echo "<th>AGE</th>";
echo "<th>ACTION</th>";
echo "</tr>";
foreach ($employees as $employee) {
    echo "<tr>";
    echo "<td>" . $employee->id . "</td>";
    echo "<td>" . $employee->name . "</td>";
    echo "<td>" . $employee->age . "</td>";
    echo "<td>";
    echo Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['employee/update', 'id' => $employee->id]) . " | " . Html::a(
        '<i class="glyphicon glyphicon-trash"></i>',
        ['employee/delete', 'id' => $employee->id],
        ['onclick' => 'return (confirm("Apakah data mau dihapus?")?true:false);']
    ) . "</td>";

    echo "</tr>";
}
echo "</table>";

echo \yii\widgets\LinkPager::widget([
    'pagination' => $pagination,
]);
