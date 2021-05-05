<?php
/* @var $this yii\web\View */
/* @var $navigation array */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <h1>Панель управления администратора</h1>

    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($navigation as $item): ?>
            <li><a href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
