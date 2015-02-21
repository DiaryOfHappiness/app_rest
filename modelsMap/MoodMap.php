<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use app\models\Mood;
use app\models\User;
use Yii;

/**
 * Модель Mood
 * Class MessageMap
 * @package app\modelsMap
 */
class MoodMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    /**
     * @var - Ідентифікатор оцінки
     */
    public $id;
    /**
     * @var - Оцінка
     */
    public $rating;
    /**
     * @var - Час створення
     */
    public $date_create;

    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
            'id' => 'MODEL.MOOD.ID',
            'rating' => 'MODEL.MOOD.RATING',
            'user' => 'MODEL.MOOD.USER',
            'date_create' => 'MODEL.MOOD.DATE_CREATE',
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
            ['id', 'required', 'on' => ['read', 'update', 'delete']],
            [['rating', 'date_create'], 'required', 'on' => ['create', 'update'],
                'message' => 'MODEL.MOOD.ERROR.IS_EMPTY'],
            ['date_create', 'date', 'on' => ['create', 'update'], 'format' => 'Y-m-d H:i:s'],
            [['rating'], 'number', 'max' => 10, 'on' => ['create', 'update'],
                'message' => 'MODEL.MOOD.ERROR.NOT_STRING',],
            [['id', 'rating', 'date_create'], 'safe'],
        ];
    }

    /**
     * Створити сутність оцінка
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function create()
    {
        if($this->validate()){
            $mood = Mood::find()
                ->where('user = :user AND date_create = :date_create', [':user' => User::getUserId(),
                    ':date_create' => $this->date_create])
                ->one();

            if(!$mood){
                $mood = new Mood();

                $mood->date_create_server = date('Y-m-d H:i:s');
                $mood->user = User::getUserId();
            }

            $mood->rating = $this->rating;
            $mood->date_create = $this->date_create;

            $mood->save();

            $this->id = $mood->id;
        }

        return $this;
    }

    /**
     * Повернути одну оцінку
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read()
    {
        if($this->validate()){

            $mood = Mood::find()
                ->where('user = :user AND id = :id', [':id' => $this->id, ':user' => User::getUserId()])
                ->asArray()
                ->one();

            if(!$mood){
                $this->addError('id', 'MODEL.MOOD.ERROR.NO_MOOD');

                return $this;
            }

            return $mood;
        }

        return $this;
    }

    /**
     * Обновити дані оцінки
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function update()
    {
        if($this->validate()){
            $mood = Mood::find()
                ->where('user = :user AND id = :id', [':user' => User::getUserId(), ':id' => $this->id])
                ->one();

            if(!$mood){
                $this->addError('id', 'MODEL.MOOD.ERROR.NO_MOOD');

                return $this;
            }

            if($mood->date_create != $this->date_create){
                $mood = Mood::find()
                    ->where('user = :user AND date_create = :date_create', [':user' => User::getUserId(),
                        ':date_create' => $this->date_create])
                    ->one();
            }

            $mood->rating = $this->rating;
            $mood->date_create = $this->date_create;

            $mood->save();
        }

        return $this;
    }

    /**
     * Видалити оцінку
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     */
    public function delete()
    {
        if($this->validate()){
            Mood::deleteAll('user = :user AND id = :id', [':id' => $this->id, ':user' => User::getUserId()]);
        }

        return $this;
    }

    /**
     * Видалити всі оцінки
     * @return array|mixed
     */
    public function delete_all()
    {
        return ['message' => 'MODEL.MOOD.MESSAGE.CLEAR_MOOD'];
    }

    /**
     * Повертає всі оцінки
     * @param DataContainer $dataContainer - додаткові параметри (наприклад параметри фільтрування)
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidParamException
     */
    public function getList(DataContainer $dataContainer = null)
    {
        if($this->validate()){
            $moods = Mood::find()
                ->where('user = :user', [':user' => User::getUserId()])
                ->asArray()
                ->all();

            return $moods;
        }

        return $this;
    }
}