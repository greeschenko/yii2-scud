<?php

namespace greeschenko\scud\controllers;

use Yii;
use yii\web\Controller;

class SensorController extends Controller
{
    public $module;

    public function init()
    {
        $this->module = Yii::$app->getModule('pay');
        parent::init();
    }

    public function actionList()
    {
        return 'test';
    }

    public function actionTest()
    {
        return 'test';
    }
}
