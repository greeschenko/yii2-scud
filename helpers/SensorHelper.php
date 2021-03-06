<?php

namespace greeschenko\scud\helpers;

/**
 * Class SensorHelper.
 *
 * @author Oleksiy Hryshchenko
 */
class SensorHelper
{
    public $apiHelper;

    /**
     * @param mixed
     */
    public function __construct()
    {
        $this->apiHelper = new JsonApiHelper();
    }

    //TODO
    //readInput //read all input request

    /**
     * undocumented function.
     */
    public function readInput()
    {
        $data = $this->apiHelper->readRequest();

        $data = (array) $data;

        return $data;
    }

    //readMessages //case with processing all posible types
    //  powerOn
    //  checkAccess
    //  ping
    //  events
    //      readEvents //case with processing all posible events
    //readInputTest //test all posible variants of the messages and events
    //sendMessages //send messages array
    //  genSetActiveMsg
    //  genOpenDoorMsg
    //  genSetModeMsg
    //  genSetTimezoneMsg
    //  genSetDoorParamsMsg
    //  genAddCardsMsg
    //  genDelCardsMsg
    //  genClearCardsMsg
}
