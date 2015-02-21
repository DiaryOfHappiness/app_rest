<?php

namespace app\modules\api\v1\controllers;

use app\components\base\APIController;

class DefaultController extends APIController
{
    public function actionIndex()
    {
        $message = ['Message'=>'Web-service'];

        $this->dataContainerResponse->setData($message);

        return $this->dataContainerResponse->getData();
    }
}
