<?php
namespace frontend\controllers;

use common\models\Bonus;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Bonus controller
 */
class BonusController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionGet()
    {
        $bonus = $this->getRandomAvailableBonus();

        return $this->renderPartial('bonus', [
            'bonus' => $bonus
        ]);
    }

    /**
     * @return Bonus
     */
    protected function getRandomAvailableBonus()
    {
        $bonuses = Bonus::findAvailableBonuses();

        $count = sizeof($bonuses);
        $randKey = rand(0, $count - 1);

        return $bonuses[$randKey];
    }
}
