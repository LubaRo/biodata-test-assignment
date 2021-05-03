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
        $attributes = $this->client->getUserAttributes();
        $email      = ArrayHelper::getValue($attributes, 'email');
        $id         = ArrayHelper::getValue($attributes, 'id');

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            $this->processWithGuest($auth, $email, $id, $email);

        } else {
            Yii::$app->getSession()->setFlash('info', [
                Yii::t('app','You are already logged in')
            ]);
        }
    }

    protected function processWithGuest($auth, $email, $id, $nickname)
    {
        if ($auth) { // login
            /* @var User $user */
            $user = $auth->user;
            Yii::$app->user->login($user);
            Yii::$app->getSession()->setFlash('info', [
                Yii::t('app','You are successfully logged in')
            ]);
        } else { // signup
            $password = Yii::$app->security->generateRandomString(8);
            $user = new User([
                'username' => $nickname,
                'email' => $email,
                'password' => $password,
                'status' => 10,
            ]);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();

            $transaction = User::getDb()->beginTransaction();

            if ($user->save()) {
                $auth = new Auth([
                    'user_id' => $user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$id,
                ]);
                if ($auth->save()) {
                    $transaction->commit();
                    Yii::$app->user->login($user);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to save {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Unable to save user: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($user->getErrors()),
                    ]),
                ]);
            }
        }
    }
}