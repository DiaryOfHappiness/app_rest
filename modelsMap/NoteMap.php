<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\Constant;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use app\models\Note;
use app\models\NoteType;
use app\models\User;
use Yii;

/**
 * Модель
 * Class NoteMap
 * @package app\modelsMap
 */
class NoteMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    public $id;
    public $text;
    public $date_create;
    public $date_update;
    public $id_note_type;

    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
            'id' => 'MODEL.NOTE_TYPE.ATTRIBUTE.ID',
            'text' => 'MODEL.NOTE_TYPE.ATTRIBUTE.TEXT',
            'date_create' => 'MODEL.NOTE_TYPE.ATTRIBUTE.DATE_CREATE',
            'date_update' => 'MODEL.NOTE_TYPE.ATTRIBUTE.DATE_UPDATE',
            'id_note_type' => 'MODEL.NOTE_TYPE.ATTRIBUTE.ID_NOTE_TYPE',
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
            [['id'], 'required', 'on' => ['read', 'update', 'delete']],
            [['text'], 'required', 'on' => ['create', 'update']],
//            [['date_create', 'date_update'], 'date', 'on' => ['create', 'update'], 'format' => 'Y-m-d H:i:s'],
            [['id', 'text', 'date_create', 'date_update', 'id_note_type'], 'safe'],
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
        if($this->validate()){
            $note = new Note();
            $note->text = $this->text;
            $note->date_create = Constant::DEFAULT_DATE == $this->date_create 
                ? $this->date_create : date('Y-m-d H:i:s');
            $note->date_update = $this->date_update ? $this->date_update : Constant::DEFAULT_DATE;
            $note->id_note_type = $this->id_note_type;
            $note->ref_user = User::getUserId();
            $note->date_create_server = date('Y-m-d H:i:s');

            $note->save();

            $this->id = $note->id;
        }

        return $this;
    }

    /**
     * Повернути однин запис
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read()
    {
        if($this->validate()){
            $note = Note::find()
                ->where('ref_user = :ref_user AND id = :id', [':id' => $this->id, ':ref_user' => User::getUserId()])
                ->asArray()
                ->one();

            if(!$note){
                $this->addError('id', 'MODEL.NOTE_TYPE.ERROR.NO_NOTE_TYPE');

                return $this;
            }

            return $note;
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
            $note = Note::find()
                ->where('id = :id AND ref_user = :ref_user', [':id' => $this->id, ':ref_user' => User::getUserId()])
                ->one();

            if(!$note){
                $this->addError('id', 'MODEL.NOTE_TYPE.ERROR.NO_MESSAGE');

                return $this;
            }

            $note->text = $this->text;
            $note->date_update = Constant::DEFAULT_DATE == $this->date_update
                ? date('Y-m-d H:i:s') : $this->date_update;
            $note->id_note_type = $this->id_note_type;

            $note->save();
            dump($note->getErrors());
        }

        return $this;
    }

    /**
     * Видалити запис
     * @return $this
     * @throws \yii\base\InvalidParamException
     */
    public function delete()
    {
        if($this->validate()){
            Note::deleteAll('ref_user = :ref_user AND id = :id',
                [':id' => $this->id, ':ref_user' => User::getUserId()]);
        }

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