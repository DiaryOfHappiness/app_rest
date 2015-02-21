<?php

namespace app\modules\api\v1\controllers;

use app\components\base\APIController;

/**
 * Авторизація
 * Class ClientController
 * @package app\modules\api\v1\controllers
 */
class Auth_tokenController extends APIController
{
    /**
     * Ініціалізує контроллер
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
//        var_dump(555);die;
        return parent::__construct($id, $module, $config = []);
    }

    /**
     * Екшен авторизації
     * @return mixed|string
     */
    public function actionCreate()
    {
        var_dump(12);die;

        $this->selfModel->setScenario('create');
        $this->selfModel->setAttributes($this->requestData->getAttributes()->getData());
        $this->selfModel->create();

        $this->dataContainerResponse->setData($this->selfModel);

        return $this->dataContainerResponse->getData();
    }
}
