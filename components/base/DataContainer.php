<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 01.12.2014
 * Time: 14:28
 */

namespace app\components\base;
use yii\base\Model;
use yii\db\Exception;

/**
 * Клас з даними
 * Його краще використовувати для передачі даних, менше путанини буде з типом того, що передається
 * З цим классом можна поводитися як з масивом або об'єктом
 * Class DataContainer
 * @package app\components\base
 */
class DataContainer implements \IteratorAggregate, \ArrayAccess
{
    /**
     * Константа формату json
     */
    const FORMAT_JSON = 'json';
    /**
     * Константа формату array
     */
    const FORMAT_ARRAY = 'array';

    /**
     * @var array - Зберігаються дані DataContainer
     */
    protected $container = [];

    /**
     * @param null $data
     */
    public function __construct($data = null)
    {
        if($data instanceof Model){
            $this->container = $data->getAttributes();
        } else if($data){
            $this->container = (array) $data;
        }
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return isset($this->container[$name]) ? $this->container[$name] : null;
    }

    /**
     * @param $offset
     * @param $value
     */
    public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
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
        if(self::FORMAT_ARRAY === $format){
            return $this->container;
        } elseif(self::FORMAT_JSON === $format){
            return json_encode($this->container);
        }

        return null;
    }
}