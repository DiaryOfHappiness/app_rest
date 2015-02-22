<?php

namespace app\components\base;


use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Базовий контроллер для API
 * Базові методи і атрибути для контроллерів API виносити в цей клас
 * Class BaseController
 * @package app\components\base
 */
abstract class APIController extends BaseController
{
    /**
     * @var - Зберігає головну модель з якою працює контроллер API
     */
    protected $selfModel;
    /**
     * @var - Модель із запитами
     */
    protected $requestData;
    /**
     * @var - Контейнер для повернення даних
     */
    protected $dataContainerResponse;

    /**
     * Ініціалізує контроллер
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        $this->requestData = new BaseRequestData();
        $this->dataContainerResponse = new DataContainerResponse();

        return parent::__construct($id, $module, $config = []);
    }

    public function init()
    {
        parent::init();
//        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//        ];
        return $behaviors;
    }
}