<?php

use yii\widgets\Block;
?>

<?php Block::begin([
    'id' => 'sidebar'
]); ?>
<h1> Menu </h1>
<ul>
    <li>Home</li>
    <li>About</li>
    <li>Contact</li>
</ul>
<?php Block::end(); ?>

<?= $this->render('contentblog') ?>