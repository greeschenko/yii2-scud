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
class Sensor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sensor}}';
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
                'user_id',
                'created_at',
                'updated_at',
                'active',
                'mode',
            ], 'integer'],
            [[
                'sn',
                'fw',
                'conn_fw',
                'controller_ip',
            ], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sn' => 'серийний номер',
            'fw' => 'версия прошивки контроллера',
            'conn_fw' => 'версия прошивки модуля связи',
            'active' => 'состояние активации',
            'mode' => 'режим работы контроллера',
            'controller_ip' => 'IP контроллера',
        ];
    }
}
