<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use app\models\NoteType;
use app\models\User;
use Yii;

/**
 * Модель
 * Class NoteTypeMap
 * @package app\modelsMap
 */
class NoteTypeMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * Карта валідації
     * Відповідний валідатор запускаєть при певному сценарії
     * @return array - валідатори
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * Створити запис
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function create()
    {
//        0000-00-00 00:00:00
        return $this;
    }

    /**
     * Повернути однин запис
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read()
    {
        return $this;
    }

    /**
     * Обновити дані запису
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function update()
    {
        return $this;
    }

    /**
     * Видалити запис
     * @return $this
     * @throws \yii\base\InvalidParamException
     */
    public function delete()
    {
        return $this;
    }

    /**
     * Видалити всі записи
     * @return array|mixed
     */
    public function delete_all()
    {
        return $this;
    }

    /**
     * Повертає один запис
     * @param DataContainer $dataContainer - додаткові параметри (наприклад параметри фільтрування)
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidParamException
     */
    public function getList(DataContainer $dataContainer = null)
    {
        $list = NoteType::find()
            ->asArray()
            ->all();

        return $list;
    }
}