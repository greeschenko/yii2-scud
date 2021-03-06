<?php

namespace greeschenko\scud\controllers;

use Yii;
use yii\web\Controller;
use greeschenko\scud\helpers\SensorHelper;
use greeschenko\scud\helpers\JsonApiHelper;
use greeschenko\scud\models\Sensor;
use greeschenko\scud\models\SensorSearch;
use greeschenko\scud\models\SensorEventsSearch;

class SensorController extends Controller
{
    public $module;
    public $api;
    public $apiHelper;

    public function init()
    {
        $this->module = Yii::$app->getModule('scud');
        $this->api = new SensorHelper();
        $this->apiHelper = new JsonApiHelper();

        parent::init();
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['server'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionList()
    {
        $searchModel = new SensorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEvents()
    {
        $searchModel = new SensorEventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('events', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionServer()
    {
        $res = [];
        $req = $this->api->readInput();
        $req = (array) $req;

        if (isset($req['sn'])) {
            $model = Sensor::find()->where(['sn' => $req['sn']])->one();
            if ($model == null) {
                $model = new Sensor();
                $model->sn = $req['sn'];
                if ($model->save()) {
                    $res[] = 'add sensor '.$model->sn;
                } else {
                    $res[] = $model->errors;
                }
            }
        } else {
            $res[] = 'wrong data';
            $res[] = $req;
            $res[] = $req['sn'];
        }

        $model->handleMessages($req);

        return json_encode($res);
    }

    public function actionTestClient()
    {
        $data = [];
        //in
        //  power_on
        $data[] = [
            'type' => 'Z5RWEB',
            'sn' => '50001',
            'messages' => [
                [
                    'id' => 123456789,
                    'operation' => 'power_on',
                    'fw' => '1.0.1',
                    'conn_fw' => '2.0.2',
                    'active' => 0,
                    'mode' => 0,
                    'controller_ip' => '192.168.0.222',
                ],
            ],
        ];
        //  ping
        $data[] = [
            'type' => 'Z5RWEB',
            'sn' => '50001',
            'messages' => [
                [
                    'id' => 123456789,
                    'operation' => 'ping',
                    'active' => 1,
                    'mode' => 0,
                ],
            ],
        ];
        //  events
        $data[] = [
            'type' => 'Z5RWEB',
            'sn' => '50001',
            'messages' => [
                [
                    'id' => 123456789,
                    'operation' => 'events',
                    'events' => [
                        [
                            'event' => 4,
                            'card' => '00B5009EC1A8',
                            'time' => '2015-06-25 16:36:01',
                            'flag' => 0,
                        ],
                        [
                            'event' => 16,
                            'card' => '00BA00FE32A2',
                            'time' => '2015-06-25 16:36:02',
                            'flag' => 0,
                        ],
                    ],
                ],
            ],
        ];
        //  check_access
        //$data['check_access'] = [
            //'type' => 'Z5RWEB',
            //'sn' => '50001',
            //'messages' => [
                //[
                    //'id' => 123456789,
                    //'operation' => 'check_access',
                    //'card' => '00B5009EC1A8',
                    //'reader' => 1,
                //],
            //],
        //];

        foreach ($data as $key => $value) {
            $res = $this->apiHelper->sendRequest(
                $url = 'http://admin.sutkihouse.ga/scud/sensor/server',
                $protocol = 'POST',
                $value
            );
            echo $key.' --------------------------------------------------------';
            echo '<pre>';
            print_r([$res]);
            echo '</pre>';
        }

        //out
        //  set_active
        //  open_door
        //  set_mode
        //  set_timezone
        //  set_door_params
        //  add_cards
        //  del_cards
        //  clear_cards

        return false;
    }

    public function actionConsole()
    {
        return $this->render('console');
    }
}
