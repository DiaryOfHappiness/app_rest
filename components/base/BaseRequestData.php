<?php

namespace app\components\base;

/**
 * Клас з даними запита API
 * Class BaseRequestData
 * @package app\components\base
 */
class BaseRequestData
{
    /**
     * @var \yii\web\Request - модель Yii із атрибутами запиту
     */
    static private $request;
    /**
     * @var string
     */
    static private $method;
    /**
     * @var DataContainer
     */
    static private $attributes;
    /**
     * @var DataContainer
     */
    static private $parameters;
    /**
     * @var DataContainer
     */
    static private $originalParameters;
    /**
     * @var string
     */
    static private $originalData;
    /**
     * @var bool
     */
    static private $isAPI = true;

    /**
     * Ініціалізація
     */
    public function __construct()
    {
        if(!self::$request){
            self::$request = new \yii\web\Request();

            self::$method = self::$request->getMethod();
            self::$parameters = new DataContainer(self::$request->getQueryParams());
            self::$originalParameters = new DataContainer(self::$request->getQueryParams());
            self::$originalData = file_get_contents('php://input');
            self::$attributes = new DataContainer(json_decode(self::$originalData));
        }
    }

    /**
     * HTTP метод
     * @return string
     */
    public function getMethod()
    {
        return self::$method;
    }

    /**
     * Віддає атрибути запиту для АПІ
     * @return DataContainer
     */
    public function getAttributes()
    {
        return self::$attributes;
    }

    /**
     * Віддає параметри запиту для АПІ
     * @return DataContainer
     */
    public function getParameters()
    {
        return self::$parameters;
    }

    /**
     * Чи АПІ запит
     * @return bool
     */
    public function isAPI()
    {
        return self::$isAPI;
    }

    /**
     * GET параметри які прийшли, без змін
     * @return DataContainer
     */
    public function getOriginalParams()
    {
        return self::$originalParameters;
    }

    /**
     * Повертає оригінальні дані які прийшли з методом POST чи PUT
     * @return string
     */
    public function getOriginalData()
    {
        return self::$originalData;
    }
} 