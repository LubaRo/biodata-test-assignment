<?php
namespace frontend\controllers;

use common\models\Bonus;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\AuthHandler;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function oAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('login');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays profile page.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $user = $this->getCurrentUserInfo();

        $userData = Yii::$app->user->identity;
        $bonusId = $userData->bonus_id ?? null;

        return $this->render('profile', [
            'user'  => $user,
            'showBonusInfo' => $bonusId || Bonus::isAvailableToChoose(),
            'bonus' => $bonusId ? Bonus::findOne(['id' => $bonusId]) : null
        ]);
    }

    protected function getCurrentUserInfo()
    {
        $authClient = Yii::$app->authClientCollection->getClient('facebook');

        $data = [];

        try {
            $data = $authClient->getFormattedProfileInfo();

        } catch (\Exception $exception) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', 'Не удалось получить подробную информацию о профиле'),
            ]);
        }


        if ($data['picture']) {
            $userInfo['picture'] = $data['picture'];
            unset($data['picture']);
        }
        $userInfo['data'] = $data;

        return $userInfo;
    }
}
