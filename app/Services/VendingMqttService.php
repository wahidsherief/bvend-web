<?php

namespace App\Services;

use Mqtt;

class VendingMqttService
{
    public function publish($request, $transactionId, $packetId)
    {
        $params = $this->setParameters($request, $transactionId, $packetId);
        $topic = '1000/' . $params['machine_number'];
        $message = $params['message'];

        $isPublished = Mqtt::ConnectAndPublish($topic, $message, $packetId);

        if(!$isPublished) {
            return false;
        }

        return $this->subscribe($request);
    }


    public function subscribe($params)
    {
        // $topic = '1000/' . $params['machine_number']; //might be something like this
        $topic = '1000/1000001';
        $packetId = $params['c']; // packate_id

        Mqtt::ConnectAndSubscribe($topic, function ($topic, $message) {
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$message\n\n";

            return $message;
        }, $packetId);
    }

    private function setParameters($request, $transactionId, $packetId)
    {
        $m = $this->getMessageFormat($request);

        $params = [];

        $params['machine_number'] = $request->machine_id;
        $params['no_of_products'] = $request->no_of_products;
        $params['channel_number'] = $request->channel_number; // need to think how to design
        $params['c'] = $packetId;
        $params['f'] = '1000001';
        $params['t'] = $request->machine_number;
        $params['m'] = $m;
        $params['s'] = isset($transactionId) ? $transactionId : '0' ; // sales_id
        $params['k'] = $request->customer_number; // user-id
        $params['e'] = md5('1000001' . $request->machine_id . $transactionId . $m . $request->customer_number);
        $message = $this->message($params);
        $params['message'] = $message;

        return $params;
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
            return $request->no_of_products . '&' . $request->channel_number;
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
