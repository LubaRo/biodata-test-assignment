<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpHeaderAuth;
use api\models\User;
use yii\web\ForbiddenHttpException;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function($action) {
            return new \yii\data\ActiveDataProvider([
                'query' => \api\models\User::find()->where(['is_admin' => 0]),
            ]);
        };

        return $actions;
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param \yii\base\Model $model the model to be accessed. If `null`, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($model && $model->is_admin) {
            throw new \yii\web\ForbiddenHttpException('You don\'t have permission to this source');
        }
    }
}