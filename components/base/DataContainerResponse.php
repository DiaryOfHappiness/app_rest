<?php

namespace app\components\base;
use yii\base\Model;

/**
 * Клас з даними
 * Його краще використовувати для передачі даних, менше путанини буде з типом того, що передається
 * З цим классом можна поводитися як з масивом або як з об'єктом
 * Class DataContainerResponse
 * @package app\components\base
 */
class DataContainerResponse extends DataContainer
{
    /**
     * Ініціалізація
     * @param null $data
     */
   public function __construct($data = null)
   {
       $this->container['success'] = true;
       $this->container['status'] = 200;
       $this->container['message'] = 'OK';
       $this->container['result'] = [];
       $this->container['errors'] = [];

       if($data){
           $this->setData($data);
       }
   }

    /**
     * Встановлює значення елемента у відповідь
     * @param null $data
     */
    public function setData($data = null)
    {
        if($data instanceof Model){
            if($data->getErrors()){
                $this->container['errors'] = array_merge($this->container['errors'], $data->getErrors());
            } else {
                $this->container['result'] = array_merge($data->getAttributes(), $this->container['result']) ;
            }
        } elseif($data instanceof DataContainer){
            $this->container['result'] = array_merge($data->getData(), $this->container['result']) ;
        } elseif($data){
            $this->container['result'] = array_merge((array) $data, $this->container['result']) ;
        }
    }

    /**
     * Встановлює значення до масиву відповіді
     * @param $key
     * @param $value
     */
    public function setValue($key, $value)
    {
        $this->container['result'][$key] = $value;
    }

    /**
     * Встановлює значення до масиву відповіді
     * @param $key
     * @param $text
     */
    public function setError($key, $text)
    {
        $this->container['errors'][$key] = $text;
    }

    /**
     * Видаляє значення відповіді, і встановлює значення яке передають в метод
     * @param $value
     */
    public function setOnlyValue($value)
    {
        $this->container['result'] = $value;
    }

    /**
     * Повертає всі дані
     * Дані актуально повертати для серіалізації
     * @param string $format - формат в якому повернути дані
     * формат ще не дороблений, доробити, коли це буде потрібно
     * @return mixed
     */
    public function getData($format = self::FORMAT_ARRAY)
    {
        $data = parent::getData($format);

        if(!empty($data['errors'])){
            unset($data['result']);
            $data['success'] = false;
            $data['message'] = 'error';
        } else {
            unset($data['errors']);
        }

        return $data;
    }
}