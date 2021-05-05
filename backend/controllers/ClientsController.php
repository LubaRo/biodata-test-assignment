<?php

namespace backend\controllers;

use Yii;
use backend\models\ClientsSearch;
use yii\web\Controller;

/**
 * ClientsController implements the CRUD actions for User model.
 */
class ClientsController extends Controller
{

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
