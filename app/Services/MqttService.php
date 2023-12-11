<?php

namespace App\Services;

use Mqtt;

class MqttService
{
    public function readPortStatus($numberOfData)
    {
        $data = [];

        for ($i = 1; $i <= $numberOfData; $i++) {
            $data[] = [
                "type" => "BicycleCharger",
                "oid" => (string)$i,
                "p" => "portstate"
            ];
        }

        $result = [
            "pv" => 1,
            "fn" => "rd",
            "ts" => 0,
            "uid" => 0,
            "ck" => "0",
            "from" => "00000001",
            "pkg" => [
                [
                    "to" => "1",
                    "data" => $data
                ]
            ]
        ];

        $formattedResult = str_replace("=>", ":", json_encode($result, JSON_PRETTY_PRINT));
        $message = str_replace(["\n", "\r", "\t"], '', $formattedResult);

        return $message;
    }

    public function replyPortStatus($numberOfData, $statusValue)
    {
        $data = [];

        for ($i = 1; $i <= $numberOfData; $i++) {
            $data[] = [
                "type" => "BicycleCharger",
                "oid" => (string)$i,
                "p" => "portstate",
                "val" => (string)$statusValue
            ];
        }

        $result = [
            "pv" => 1,
            "fn" => "rdf",
            "ts" => 1000,
            "uid" => 0,
            "ck" => "00f7",
            "from" => "1",
            "pkg" => [
                [
                    "to" => "00000001",
                    "data" => $data
                ]
            ]
        ];

        $formattedResult = str_replace("=>", ":", json_encode($result, JSON_PRETTY_PRINT));
        $message = str_replace(["\n", "\r", "\t"], '', $formattedResult);

        return $message;
    }

    public function sendOrder($orderNumber, $amount)
    {
        $result = [
            "pv" => 1,
            "fn" => "wt",
            "ts" => 0,
            "uid" => 0,
            "ck" => "0",
            "from" => "00000001",
            "pkg" => [
                [
                    "to" => "1",
                    "data" => [
                        [
                            "type" => "BicycleCharger",
                            "oid" => 2,
                            "p" => "ordernum",
                            "val" => (string)$orderNumber
                        ],
                        [
                            "type" => "BicycleCharger",
                            "oid" => 2,
                            "p" => "numMoney",
                            "val" => $amount
                        ]
                    ]
                ]
            ]
        ];

        $formattedResult = str_replace("=>", ":", json_encode($result, JSON_PRETTY_PRINT));
        $message = str_replace(["\n", "\r", "\t"], '', $formattedResult);

        return $message;
    }

    public function replyOrder($orderNumber, $orderState)
    {
        $reply = [
            "pv" => 1,
            "fn" => "wtf",
            "ts" => 0,
            "uid" => 0,
            "ck" => "0",
            "from" => "1",
            "pkg" => [
                [
                    "to" => "00000001",
                    "data" => [
                        [
                            "type" => "BicycleCharger",
                            "oid" => 2,
                            "p" => "ordernum",
                            "val" => $orderNumber
                        ],
                        [
                            "type" => "BicycleCharger",
                            "oid" => 2,
                            "p" => "orderstate",
                            "val" => $orderState
                        ]
                    ]
                ]
            ]
        ];

        $replacedReply = str_replace("=>", ":", json_encode($reply, JSON_PRETTY_PRINT));
        $message = str_replace(["\n", "\r", "\t"], '', $formattedResult);

        return $message;
    }



    public function publish($topic, $message)
    {
        return Mqtt::ConnectAndPublish($topic, $message);
    }

    public function subscribe($topic)
    {
        Mqtt::ConnectAndSubscribe($topic, function ($topic, $message) {
            echo "Msg Received: \n";
            echo "Topic: {$topic}\n\n";
            echo "\t$message\n\n";

            return $message;
        });
    }
}
