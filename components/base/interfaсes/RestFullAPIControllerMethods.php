<?php

namespace app\components\base\interfaсes;

/**
 * Інтерфейс для методів RestFull API
 * Interface RestFullAPIControllerMethods
 * @package app\components\base\interfaсes
 */
interface RestFullAPIControllerMethods
{
    /**
     * Повертає список сутностей
     * @return mixed
     */
    public function actionList();

    /**
     * Створити сутність
     * @return mixed|string
     */
    public function actionCreate();

    /**
     * Повернути сутність по ідентифікатору
     * @param null $id - ідентифікатор клієнта
     * @return mixed|string
     */
    public function actionRead($id = null);

    /**
     * Оновити дані сутності
     * @param null $id - ідентифікатор сутності
     * @return mixed|string
     */
    public function actionUpdate($id = null);

    /**
     * Видалити сутність по ідентифікатору
     * @param null $id -  - ідентифікатор сутності
     * @return mixed|string
     */
    public function actionDelete($id = null);

    /**
     * Видалити всі сутності
     * @return mixed|string
     */
    public function actionDelete_all();
}