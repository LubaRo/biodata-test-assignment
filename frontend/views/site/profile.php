<?php

/* @var $this yii\web\View */
/* @var $user array */

$this->title = 'My Profile';
?>
<div class="site-profile-page">
    <h1>Profile info</h1>

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
</div>
