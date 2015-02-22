<?php

namespace app\modelsMap;

use app\components\base\BaseModelMap;
use app\components\base\DataContainer;
use app\components\base\interfaсes\RestFullAPIModelMapMethods;
use app\models\MUser;
use app\models\User;
use Yii;

/**
 * Модель Message
 * Class MessageMap
 * @package app\modelsMap
 */
class UserMap extends BaseModelMap implements RestFullAPIModelMapMethods
{
    /**
     * @var - Ідентифікатор запису
     */
    public $id;
    /**
     * @var - Ім'я
     */
    public $name;
    /**
     * @var - Пароль
     */
    public $password;
    /**
     * @var - Підтвердження паролю
     */
    public $password_2;
    /**
     * @var - Електронна адреса
     */
    public $email;

    /**
     * Атрибути з кодом для перекладу
     * Зберігається коди атрибутів
     * @return array - коди атрибутів
     */
    public function attributeLabels()
    {
        return [
            'id' => 'MODEL.USER.ID',
            'name' => 'MODEL.USER.NAME',
            'password' => 'MODEL.USER.PASSWORD',
            'password_2' => 'MODEL.USER.PASSWORD_2',
            'email' => 'MODEL.USER.EMAIL',
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
                'message' => 'MODEL.USER.ERROR.IS_EMPTY'],
            [['name', 'password', 'password_2'], 'required', 'on' => ['create', 'update'],
                'message' => 'MODEL.USER.ERROR.IS_EMPTY'],
            [['description', 'password', 'password_2'], 'string', 'on' => ['create', 'update'],
                'message' => 'MODEL.USER.ERROR.NOT_STRING'],
            [['password'], 'password', 'on' => ['create', 'update'],
                'message' => 'MODEL.USER.ERROR.NOT_STRING'],
            ['email', 'email', 'on' => ['create', 'update']],
            [['id', 'name', 'password', 'password_2', 'email'], 'safe'],
        ];
    }

    /**
     * Створити сутність користувач
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function create()
    {
        if($this->validate()){
            $user = MUser::find()
                ->where('email = :email', [':email' => $this->email])
                ->one();

            if($user){
                $this->addError('id', 'MODEL.USER.ERROR.USER_EXISTS');

                return $this;
            }

            $user = new MUser();
            $user->password = $hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->mame = $this->name;
            $user->email = $this->email;

            $user->save();

            $this->id = $user->id;
        }

        return $this;
    }

    /**
     * Повернути користувача по ідентифікатору
     * @return $this|array|mixed|null|\yii\db\ActiveRecord
     * @throws \yii\base\InvalidParamException
     */
    public function read()
    {
        if($this->validate()){
            $user = MUser::find()
                ->where('id = :id', [':id' => User::getUserId()])
                ->asArray()
                ->one();

            if(!$user){
                $this->addError('id', 'MODEL.USER.ERROR.NO_USER');

                return $this;
            }

            $user['password'] = '';

            return $user;
        }

        return $this;
    }

    /**
     * Обновити дані користувача
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     * @throws \yii\db\Exception
     */
    public function update()
    {
        if($this->validate()){
            $user = MUser::find()
                ->where('id = :id', [':id' => User::getUserId()])
                ->one();

            if(!$user){
                $this->addError('id', 'MODEL.USER.ERROR.NO_USER');

                return $this;
            }

            if($user->email != $this->email){
                $user = MUser::find()
                    ->where('email = :email', [':email' => $this->email])
                    ->one();

                if($user){
                    $this->addError('id', 'MODEL.USER.ERROR.USER_EXISTS');

                    return $this;
                }
            }

            $user->password = $hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->mame = $this->name;
            $user->email = $this->email;

            $user->save();
        }

        return $this;
    }

    /**
     * Видалити користувача
     * @return $this|mixed
     * @throws \yii\base\InvalidParamException
     */
    public function delete()
    {
        if($this->validate()){
            MUser::deleteAll('id = :id', [':id' => User::getUserId()]);
        }

        return $this;
    }

    /**
     * Видалити всіх користувачів
     * @return array|mixed
     */
    public function delete_all()
    {
        return ['message' => 'MODEL.USER.MESSAGE.USER_MESSAGE'];
    }

    /**
     * Повертає всіх користувачів
     * @param DataContainer $dataContainer - додаткові параметри (наприклад параметри фільтрування)
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidParamException
     */
    public function getList(DataContainer $dataContainer = null)
    {
        return [];
    }

    /**
     * Валідація пароля
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if($this->password != $this->password_2){
            $this->addError($attribute, 'MODEL.USER.ERROR.OTHER_PASSWORD');
        }
    }
}