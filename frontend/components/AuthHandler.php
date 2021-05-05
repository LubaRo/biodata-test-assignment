<?php

namespace frontend\components;

use frontend\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->getSession()->setFlash('info', [
                Yii::t('app','You are already logged in')
            ]);
            return;
        }

        $this->processAuth();
    }

    /**
     * @param User $user
     */
    protected function processLogin($user)
    {
        Yii::$app->user->login($user);

        Yii::$app->getSession()->setFlash('info', [
            Yii::t('app','You are successfully logged in')
        ]);
    }

    protected function createNewUser()
    {
        $user = new User([
            'username' => '',
            'email' => '',
            'password' => '',
            'password_reset_token' => null,
            'password_hash' => '',
            'status' => User::STATUS_ACTIVE,
        ]);
        $user->generateAuthKey();

        return $user;
    }

    protected function processSignup($id)
    {
        $user = $this->createNewUser();
        $transaction = User::getDb()->beginTransaction();

        if (!$user->save()) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', 'Unable to save user: {errors}', [
                    'errors' => json_encode($user->getErrors()),
                ]),
            ]);
            return;
        }

        $auth = new Auth([
            'user_id'   => $user->id,
            'source'    => $this->client->getId(),
            'source_id' => (string) $id,
        ]);

        if (!$auth->save()) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', 'Unable to save {client} account: {errors}', [
                    'client' => $this->client->getTitle(),
                    'errors' => json_encode($auth->getErrors()),
                ]),
            ]);
            return;
        }

        $transaction->commit();

        Yii::$app->user->login($user);
    }

    protected function processAuth()
    {
        $attributes = $this->client->getUserAttributes();
        $clientId   = ArrayHelper::getValue($attributes, 'id');

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $clientId,
        ])->one();

        if ($auth) {
            $this->processLogin($auth->user);

        } else {
            $this->processSignup($clientId);
        }
    }
}