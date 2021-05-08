<?php

/* @var $this yii\web\View */
/* @var $user array */
/* @var $showBonusInfo bool */
/* @var $bonus Bonus */

$this->title = 'My Profile';
?>
<div class="site-profile-page">
    <h1>Данные профиля</h1>

    <div class="container profiles-data">
        <div class="col-md-1">
            <div class="profile-picture">
                <img src="<?= $user['picture'] ?? 'user-icon.png' ?>">
            </div>
        </div>
        <div class="col-md-11">
            <?php foreach ($user['data'] as $data): ?>
                <div class="row">
                    <?= $data ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($showBonusInfo) {
        echo $this->render('//bonus/bonus',['bonus' => $bonus]);
    }
    ?>
</div>
