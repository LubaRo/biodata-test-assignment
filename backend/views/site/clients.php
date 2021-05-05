<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список клиентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Дата регистрации',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDateTime($model->created_at, 'MM/dd/yyyy HH:mm:ss');
                }
            ],
            [
                'label' => 'Бонус',
                'format'=>'raw',
                'value' => function ($model) {
                    $bonusId = $model->bonus_id;
                    $bonus = $bonusId ? \common\models\Bonus::findOne(['id' => $bonusId]) : null;

                    if (!$bonus) {
                        return '-';
                    }

                    return Html::a($bonus->name, ['//bonus/view', 'id' => $bonus->id]);
                }
            ],
        ],
    ]); ?>
</div>
