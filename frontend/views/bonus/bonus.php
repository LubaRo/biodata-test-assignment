<?php

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $bonus Bonus */
?>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="bonus">
    <h3>Бесплатный бонус</h3>
    <div>
        <?php
        if (!$bonus) {
            echo $this->render('//bonus/get_bonus');
        } else {
            echo $this->render('//bonus/selected_bonus',['bonus' => $bonus]);
        }
        ?>
    </div>

</div>
<?php Pjax::end(); ?>