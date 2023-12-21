<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MqttService;

class HardwareController extends Controller
{
    protected $mqttservice;

    public function __construct(MqttService $mqttservice)
    {
        $this->mqttservice = $mqttservice;
    }

    public function checkPortStatus(Request $request)
    {
        $topic = '/chargestub/channel_status_send';
        $message = $this->mqttservice->readPortStatus();
        $published = $this->mqttservice->publish($topic, $message);


        if ($published) {
            $topic = '/chargestub/channel_status_recieve';
            echo $this->mqttservice->subscribe($topic);
        }
    }
}
