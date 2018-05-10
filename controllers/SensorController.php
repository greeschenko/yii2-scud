<?php

namespace greeschenko\scud\controllers;

use Yii;
use yii\web\Controller;
use greeschenko\scud\helpers\JsonApiHelper;

class SensorController extends Controller
{
    public $module;
    public $apiHelper;

    public function init()
    {
        $this->module = Yii::$app->getModule('pay');
        $this->apiHelper = new JsonApiHelper();

        parent::init();
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['test-server'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionList()
    {
        return 'test';
    }

    public function actionTest()
    {
        return 'test';
    }

    public function actionTestClient()
    {
        $data = [
            'check1' => 'done',
            'check2' => 'done',
            'check3' => 'done',
        ];

        $res = $this->apiHelper->sendRequest(
            $url = 'http://admin.sutkihouse.ga/scud/sensor/test-server',
            //$url = 'https://www.google.com/',
            $protocol = 'POST', $data
            //$data
            //$json = 1,
            //$debag = 1
        );

        echo '<pre>';
        print_r([$res]);
        echo '</pre>';
        die;
    }

    public function actionTestServer()
    {
        $req = $this->apiHelper->readRequest();

        $req = (array) $req;

        $req['test1'] = 'testdone';

        return json_encode($req);
    }
}
