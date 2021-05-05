<?php
namespace frontend\controllers;

use common\models\Bonus;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
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
        $user = Yii::$app->user->identity;

        if ($bonus) {
            $this->applyBonus($user, $bonus);
        }

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

    /**
     * @param User $user
     * @param Bonus $bonus
     */
    protected function applyBonus($user, $bonus)
    {
        $transaction = ActiveRecord::getDb()->beginTransaction();

        $user->bonus_id = $bonus->id;
        $user->save();

        if (!$bonus->is_infinite) {
            $bonus->quantity = $bonus->quantity - 1;
            $bonus->save();
        }

        $transaction->commit();
    }
}
