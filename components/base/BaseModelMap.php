<?php

namespace app\components\base;

use yii\base\Model;

/**
 * Базовий класс для моделей Model Mapper
 * Базові методи і атрибути для моделей Model Mapper виносити в цей клас
 * Class BaseModelMap
 * @package app\components\base
 */
abstract class BaseModelMap extends Model
{
    /**
     * Автоматично заповняє дані з однієї моделі у іншу модель
     * @param Model $fromModel
     * @param Model $toModel
     */
    public function setModelToModel(Model $fromModel, Model &$toModel = null)
    {
        $toModel->setAttributes($fromModel->getAttributes());
    }
}