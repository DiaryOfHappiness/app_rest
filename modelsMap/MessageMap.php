<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use app\models\Message;
use app\models\User;
use Yii;

/**
 * Модель Message
 * Class MessageMap
 * @package app\modelsMap
 */
class MessageMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    /**
     * @var - Ідентифікатор запису
     */
    public $id;
    /**
     * @var - Опис
     */
    public $description;
    /**
     * @var - На яку дату створено текст
     */
    public $date_create;
    /**
     * @var - Тип тексту
     */
    public $type;

    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
            'id' => 'MODEL.MESSAGE.ID',
            'description' => 'MODEL.MESSAGE.DESCRIPTION',
            'date_create' => 'MODEL.MESSAGE.DATE_CREATE',
            'type' => 'MODEL.MESSAGE.TYPE',
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
            ['id', 'required', 'on' => ['read', 'update', 'delete'],
                'message' => 'MODEL.MESSAGE.ERROR.IS_EMPTY'],
            [['description'], 'required', 'on' => ['create', 'update'],
                'message' => 'MODEL.MESSAGE.ERROR.IS_EMPTY'],
            [['description'], 'string', 'on' => ['create', 'update'],
                'message' => 'MODEL.MESSAGE.ERROR.NOT_STRING'],
            ['date_create', 'date', 'on' => ['create', 'update'], 'format' => 'Y-m-d H:i:s'],
            [['id', 'description', 'date_create', 'type'], 'safe'],
        ];
    }

    /**
     * Створити сутність текст
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function create()
    {
        if($this->validate()){
            $message = new Message();
            $message->user = 1;
            $message->description = $this->description;
            $message->date_create = $this->date_create;
            $message->type = $this->type;
            $message->date_create_server = date('Y-m-d H:i:s');
            $message->save();

            $this->id = $message->id;
        }

        return $this;
    }

    /**
     * Повернути однин запис тексту
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read()
    {
        if($this->validate()){
            $message = Message::find()
                ->where('id = :id AND user = :user', [':id' => $this->id, ':user' => User::getUserId()])
                ->asArray()
                ->one();

            if(!$message){
                $this->addError('id', 'MODEL.MESSAGE.ERROR.NO_MESSAGE');

                return $this;
            }

            return $message;
        }

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
        if($this->validate()){
            $message = Message::find()
                ->where('id = :id AND user = :user', [':id' => $this->id, ':user' => User::getUserId()])
                ->one();

            if(!$message){
                $this->addError('id', 'MODEL.MESSAGE.ERROR.NO_MESSAGE');

                return $this;
            }

            $message->description = $this->description;
            $message->date_create = $this->date_create;
            $message->type = $this->type;

            $message->save();
        }

        return $this;
    }

    /**
     * Видалити запис
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     */
    public function delete()
    {
        if($this->validate()){
            Message::deleteAll('id = :id AND user = :user', [':id' => $this->id, ':user' => User::getUserId()]);
        }

        return $this;
    }

    /**
     * Видалити всі записи
     * @return array|mixed
     */
    public function delete_all()
    {
        return ['message' => 'MODEL.MESSAGE.MESSAGE.CLEAR_MESSAGE'];
    }

    /**
     * Повертає всі записи
     * @param DataContainer $dataContainer - додаткові параметри (наприклад параметри фільтрування)
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidParamException
     */
    public function getList(DataContainer $dataContainer = null)
    {
        if($this->validate()){
            $messages = Message::find()
                ->where('user = :user', [':user' => User::getUserId()])
                ->asArray()
                ->all();

            return $messages;
        }

        return $this;
    }
}