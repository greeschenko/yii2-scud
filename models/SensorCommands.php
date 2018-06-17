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
class SensorCommands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sensor_commands}}';
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
                'status',
                'sensor_id',
            ], 'integer'],
            [['command'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'command' => 'команда',
            'status' => 'статус',
        ];
    }
}
