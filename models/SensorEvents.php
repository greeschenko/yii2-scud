<?php

namespace greeschenko\scud\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%favorites}}".
 *
 * @property int $id
 * @property string $el_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class SensorEvents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sensor_events}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'created_at',
                'updated_at',
                'event',
                'flag',
            ], 'integer'],
            [[
                'card',
                'time',
            ], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event' => 'тип события',
            'card' => 'номер карти',
            'time' => 'время события',
            'flag' => 'флаги собития',
        ];
    }
}
