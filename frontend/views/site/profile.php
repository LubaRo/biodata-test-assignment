<?php

/* @var $this yii\web\View */
/* @var $user array */
/* @var $showBonusInfo bool */

$this->title = 'My Profile';
?>
<div class="site-profile-page">
    <h1>Данные профиля</h1>

    <div class="profiles-data">
        <div class="row">
            <div class="col-md-1"><label>Name:</label></div>
            <div class="col-md-11"><?= $user['name'] ?></div>
        </div>
        <div class="row">
            <div class="col-md-1"><label>Age:</label></div>
            <div class="col-md-11"><?= $user['age'] ?></div>
        </div>
    </div>

    <?php if ($showBonusInfo) {
        echo $this->render('//bonus/bonus',['bonus' => $bonus]);
    }
    ?>
</div>
