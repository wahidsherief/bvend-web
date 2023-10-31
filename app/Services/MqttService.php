<?php

namespace App\Services;

use Mqtt;

class MqttService
{
    public function setParameters($request, $packet_id)
    {
        $m = $this->getMessageFormat($request);
        $params = [];
        $params['machine_number'] = $request->machine_id;
        $params['no_of_products'] = $request->no_of_products;
        $params['channel_number'] = $request->channel_number;
        $params['c'] = $packet_id;
        $params['f'] = '1000001';
        $params['t'] = $request->machine_number;
        $params['m'] = $m;
        $params['s'] = isset($request->transaction_id) ? $request->transaction_id : '0' ; // sales_id
        $params['k'] = $request->customer_number; // user-id
        $params['e'] = md5('1000001'. $request->machine_id . $request->transaction_id . $m . $request->customer_number);
        $message = $this->message($params);
        $params['message'] = $message;

        return $params;
    }

    public function publish($params)
    {
        $topic = '1000/'.$params['machine_number'];
        $packet_id = $params['c']; // packet_id
        $message = $params['message'];

        return Mqtt::ConnectAndPublish($topic, $message, $packet_id);
    }
    

    public function subscribe($params)
    {
        $topic = '1000/1000001';
        $packet_id = $params['c']; // packate_id

        Mqtt::ConnectAndSubscribe($topic, function ($topic, $message) {
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$message\n\n";

            return $message;
        }, $packet_id);
    }

    private function message($params)
    {
        return json_encode([
            "c" => $params['c'],
            "f" => $params['f'],
            "t" => $params['t'],
            "m" => $params['m'],
            "s" => $params['s'], 
            "e" => $params['e']
        ]);
    }

    private function getMessageFormat($request)
    {
        if (isset($request->no_of_products, $request->channel_number)) {
            return $request->no_of_products .'&'. $request->channel_number;
        } elseif (isset($request->server_health_status)) {
            return $request->server_health_status;
        } elseif (isset($request->run_time)) {
            return $request->run_time;
        } elseif (isset($request->lighting_on_time)) {
            return $request->lighting_on_time;
        } elseif (isset($request->current_clock_time)) {
            return $request->current_clock_time;
        } else {
            return '0';
        }
    }
}
