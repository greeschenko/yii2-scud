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

    /**
     * handle messages from sensor.
     */
    public function handleMessages($req)
    {
        $resp = null;
        if (isset($req['messages'])) {
            foreach ($req['messages'] as $msg) {
                $msg = (array) $msg;
                switch ($msg['operation']) {
                    case 'power_on':
                        $resp = $this->handlePowerOn($msg);
                        break;
                    case 'ping':
                        $resp = $this->handlePing($msg);
                        break;
                    case 'check_access':
                        $resp = $this->handleCheckAccess($msg);
                        break;
                    case 'events':
                        $resp = $this->handleEvents($msg);
                        break;
                }
            }
        }

        return $resp;
    }

    /**
     * undocumented function.
     */
    private function handlePowerOn($msg)
    {
        //TODO
        //add status list on, off, undefined
        //read active: if 0 set status off
        //set sensor IP
        //set all technical info: mode fw conn_fw
        $this->attributes = (array) $msg;
        if (!$this->save()) {
            echo '<pre>';
            print_r($this->errors);
            echo '</pre>';
            die;
            throw new \yii\web\HttpException(501, 'sensor info save error');
        }

        return true;
    }

    /**
     * undocumented function.
     */
    private function handlePing($msg)
    {
        //TODO
        //check active:
        //return msgs to sensor from command queue (TODO add db table command_list)
        if ($this->mode != $msg['mode'] or $this->active != $msg['active']) {
            $this->mode = $msg['mode'];
            $this->active = $msg['active'];
            if (!$this->save()) {
                echo '<pre>';
                print_r($this->errors);
                echo '</pre>';
                die;
                throw new \yii\web\HttpException(501, 'sensor info save error');
            }
        }
        print_r($msg);
    }

    /**
     * undocumented function.
     */
    private function handleEvents($msg)
    {
        //TODO
        //read events list end handl it
        //return
            //{
            //"id":123456789,
            //"operation": "events",
            //"events_success":2  //number of events
            //}
        print_r($msg);
        foreach ($msg['events'] as $one) {
            $event = new SensorEvents();
            $event->attributes = (array) $one;
            if (!$event->save()) {
                echo '<pre>';
                print_r($event->errors);
                echo '</pre>';
                die;
                throw new \yii\web\HttpException(501, 'event save error');
            }
        }

        return true;
    }

    /**
     * undocumented function.
     */
    private function handleCheckAccess($msg)
    {
        //TODO
        //read card number
        //check card from db
        //if granted
        //return
        //{
        //"id":123456789,
        //"operation": "check_access",
        //"granted":1
        //}
        $res = [];
        $card = SensorCard::find()
            ->where(['number' => $msg['card']])
            ->one();

        if ($card != null) {
            $res = [
                'id' => time(),
                'operation' => 'check_access',
                'granted' => 1,
            ];
        }

        return $res;
    }
}
