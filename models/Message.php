<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Message".
 *
 * @property integer $id
 * @property string $description
 * @property string $date_create
 * @property string $date_create_server
 * @property integer $user
 * @property string $type
 *
 * @property User $user0
 * @property MessageType $type0
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['date_create', 'date_create_server'], 'safe'],
            [['user'], 'integer'],
            [['type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'date_create' => 'Date Create',
            'date_create_server' => 'Date Create Server',
            'user' => 'User',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(MessageType::className(), ['id' => 'type']);
    }
}
