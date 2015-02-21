<?php

namespace app\components\base\interfaсes;
use app\components\base\DataContainer;

/**
 * Інтерфейс для методів RestFull API
 * Interface RestFullAPIModelMapMethods
 * @package app\components\base\interfaсes
 */
interface RestFullAPIModelMapMethods
{
    /**
     * Повертає список сутностей
     * @param DataContainer $dataContainer - додаткові параметри (наприклад параметри фільтрування)
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidParamException
     */
    public function getList(DataContainer $dataContainer = null);

    /**
     * Створити сутність
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function create();

    /**
     * Повернути сутність
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read();

    /**
     * Оновити сутність
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function update();

    /**
     * Видалити сутність
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     */
    public function delete();

    /**
     * Видалити всі сутності
     * @return array|mixed
     */
    public function delete_all();
}