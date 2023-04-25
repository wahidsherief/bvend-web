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

    public function index()
    {
        return view('order');
    }

    public function getProducts()
    {
        return view('products');
    }

    public function showPaymentScreen($total_amount)
    {
        return view('payment', compact('total_amount'));
    }

    public function orderProducts(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '2');
        $published = $this->mqttservice->publish($params);
        
        if ($published) {
            $params = $this->mqttservice->setParameters($request, '3');
            echo $this->mqttservice->subscribe($params);
        }
    }

    public function checkMachineStatus(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '4');
        $published = $this->mqttservice->publish($params);
        
        if ($published) {
            $params = $this->mqttservice->setParameters($request, '5');
            echo $this->mqttservice->subscribe($params);
        }
    }

    public function checkProductStatusInMachine(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '15');
        echo $this->mqttservice->subscribe($params);
    }
 
    public function startMachine(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '108');
        $machine_is_on = $this->mqttservice->subscribe($params);
        
        if ($machine_is_on) {
            $params = $this->mqttservice->setParameters($request, '109');
            $received_request_of_server_time = $this->mqttservice->subscribe($params);

            if ($received_request_of_server_time) {
                $params = $this->mqttservice->setParameters($request, '110');
                $send_server_time_to_machine = $this->mqttservice->publish($params);
            }
        }

        if ($machine_is_on) {
            $params = $this->mqttservice->setParameters($request, '115');
            $send_machine_light_on_time = $this->mqttservice->publish($params);

            if ($send_machine_light_on_time) {
                $params = $this->mqttservice->setParameters($request, '116');
                $recieve_machine_light_status = $this->mqttservice->subscribe($params);
            }
        }

        if ($machine_is_on) {
            $params = $this->mqttservice->setParameters($request, '117');
            $send_machine_run_time = $this->mqttservice->publish($params);
        }
    }

    public function machineDoorOpenCloseResponse(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '122');
        echo $this->mqttservice->subscribe($params);
    }

    public function recieveMachineHealthStatus(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '123');
        $this->mqttservice->subscribe($params);
    }

    public function sendServerHealthStatus(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '124');
        $this->mqttservice->publish($params);
    }
}
