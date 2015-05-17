<?php

namespace app\modules\api\v1\controllers;

use app\components\base\APIController;
use app\components\base\interfaсes\RestFullAPIControllerMethods;

/**
 * Контролер сутності
 * Class NoteType
 * @package app\modules\api\v1\controllers
 */
class AppraisalTypeController extends APIController implements RestFullAPIControllerMethods
{
    /**
     * Ініціалізує контроллер
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        $this->selfModel = new \app\modelsMap\AppraisalTypeMap();

        return parent::__construct($id, $module, $config = []);
    }

    /**
     * Повертає список
     * @return string
     */
    public function actionList()
    {
        $list = $this->selfModel->getList();

        $this->dataContainerResponse->setData($list);

        return $this->dataContainerResponse->getData();
    }

    /**
     * Створити
     * @return string
     */
    public function actionCreate()
    {
        $this->selfModel->setScenario('create');
        $this->selfModel->setAttributes($this->requestData->getAttributes()->getData());
        $this->selfModel->create();

        $this->dataContainerResponse->setData($this->selfModel);

        return $this->dataContainerResponse->getData();
    }

    /**
     * Повернути один запис
     * @param null $id - ідентифікатор
     * @return string
     */
    public function actionRead($id = null)
    {
        $this->selfModel->setScenario('read');

        $this->selfModel->id = $id;

        $result = $this->selfModel->read();

        $this->dataContainerResponse->setData($result);

        return $this->dataContainerResponse->getData();
    }

    /**
     * Оновити дані
     * @param null $id - ідентифікатор
     * @return string
     */
    public function actionUpdate($id = null)
    {
        $this->selfModel->setScenario('update');
        $this->selfModel->id = $id;
        $this->selfModel->setAttributes($this->requestData->getAttributes()->getData());
        $this->selfModel->update();

        $this->dataContainerResponse->setData($this->selfModel);

        return $this->dataContainerResponse->getData();
    }

    /**
     * Видалити запис
     * @param null $id -  - ідентифікатор
     * @return mixed|string
     */
    public function actionDelete($id = null)
    {
        $this->selfModel->setScenario('delete');

        $this->selfModel->id = $id;

        $this->selfModel->delete();

        $this->dataContainerResponse->setData($this->selfModel);

        return $this->dataContainerResponse->getData();
    }

    /**
     * Видалити всі записи
     * @return string
     */
    public function actionDelete_all()
    {
        $message = $this->selfModel->delete_all();

        $this->dataContainerResponse->setData($message);

        return $this->dataContainerResponse->getData();
    }
}
