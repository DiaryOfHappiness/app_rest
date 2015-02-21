<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Mood".
 *
 * @property integer $id
 * @property integer $rating
 * @property integer $user
 * @property string $date_create
 * @property string $date_create_server
 */
class Mood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Mood';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rating', 'user'], 'integer'],
            [['date_create', 'date_create_server'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating' => 'Rating',
            'user' => 'User',
            'date_create' => 'Date Create',
            'date_create_server' => 'Date Create Server',
        ];
    }
}
