<?php

namespace api\components;

use Yii;

class SimpleTokenValidator
{
    public static function validateApiToken($token)
    {
        return Yii::$app->params['api_auth_token'] === $token;
    }
}