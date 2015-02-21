<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use Yii;

/**
 * Модель Для авторизації
 * Class MessageMap
 * @package app\modelsMap
 */
class AuthTockenMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    /**
     * @var - Користувач
     */
    public $user;
    /**
     * @var - Пароль
     */
    public $password;

    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
            'user' => 'MODEL.AUTH_TOKEN.USER',
            'password' => 'MODEL.AUTH_TOKEN.PASSWORD',
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
            [['user','password'], 'required'],
            [['user', 'password'], 'safe'],
        ];
    }

    /**
     * Метод для авторизації
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function auth()
    {
        if($this->validate()){


        }

        return $this;
    }

    /**
     * Валідація номерів телефонів
     * @param $attribute
     * @param $params
     */
    public function validatePhones($attribute, $params)
    {
        foreach($this->{$attribute} as $phone){
            if(!preg_match("/^\+?\d{9,12}$/", $phone)){
                $this->addError($attribute, 'MODEL.CLIENT.ERROR.BAD_FORMAT_PHONE');
            }
        }
    }
}