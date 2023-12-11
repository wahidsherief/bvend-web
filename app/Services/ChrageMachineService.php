<?php

//Reading Port Status



function readPortStatus($numberOfData) {}



// Reply to Port Status Request

function replyPortStatus($chargingPileAddress, $numberOfData, $statusValue)
{
    $data = [];

    for ($i = 1; $i <= $numberOfData; $i++) {
        $data[] = [
            "type" => "BicycleCharger",
            "oid" => "$i",
            "p" => "portstate",
            "val" => $statusValue
        ];
    }

    $reply = [
        "pv" => 1,
        "fn" => "rdf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => $data
            ]
        ]
    ];

    return json_encode($reply, JSON_PRETTY_PRINT);
}




// Charging Order - Sending Order

function sendChargingOrder($orderNumber, $amount)
{
    $command = [
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
                        "val" => $orderNumber
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

    return json_encode($command);
}

// Charging Order - Reply

function replyChargingOrder($chargingPileAddress, $orderNumber, $orderState)
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

    return json_encode($reply);
}

// Query Charging Status

function queryChargingStatus($chargingPileAddress, $portNumber)
{
    $command = [
        "pv" => 1,
        "fn" => "rd",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "portstate" // Query port status
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "duration" // Query port charging duration
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "equipPower" // Query maximum charging power of the port
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "chargepower" // Query real-time charging power of the port
                    ]
                ]
            ]
        ]
    ];

    return json_encode($command);
}

// Reply to Charging Status Query

function replyToChargingStatusQuery($chargingPileAddress, $portNumber, $status, $duration, $maxPower, $realtimePower)
{
    $reply = [
        "pv" => 1,
        "fn" => "rdf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => "00000001",
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "portstate",
                        "val" => $status // Port status
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "duration",
                        "val" => $duration // Estimated time
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "equipPower",
                        "val" => $maxPower // Maximum charging power of the port
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "chargepower",
                        "val" => $realtimePower // Real-time charging power of the port
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}

// Create Report for Charging Pile Fault

function createChargeFaultReport($chargingPileAddress, $portNumber, $faultType)
{
    $report = [
        "pv" => 1,
        "fn" => "rpt",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "faulttype",
                        "val" => $faultType // Fault type (e.g., overcurrent)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($report);
}

// Reply to Charging Fault Command

function replyToChargeFaultCommand($chargingPileAddress, $portNumber, $faultType)
{
    $reply = [
        "pv" => 1,
        "fn" => "rptf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "faulttype",
                        "val" => $faultType // Fault type (e.g., overcurrent)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}

// Open or Close Command

function generateOpenCloseCommand($chargingPileAddress, $portNumber, $status)
{
    $command = [
        "pv" => 1,
        "fn" => "wt",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "onoff", // Control port status
                        "val" => $status // 1: On, 0: Off
                    ]
                ]
            ]
        ]
    ];

    return json_encode($command);
}


// Reply to Channel Control Command

function generateChannelControlReply($chargingPileAddress, $portNumber, $status)
{
    $reply = [
        "pv" => 1,
        "fn" => "wtf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => "00000001",
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "onoff state", // Port status
                        "val" => $status // 1: Success, 2: Fail, 3: Other status
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}

// Charge Completion Feedback Command

function chargeCompletionFeedback($chargingPileAddress, $portNumber, $orderNumber, $amountUsed, $stopMode)
{
    $command = [
        "pv" => 1,
        "fn" => "rpt",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "ordernum",
                        "val" => $orderNumber // Order number
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "numMoney",
                        "val" => $amountUsed // Amount used (in minutes)
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "stopmode",
                        "val" => $stopMode // Stop mode value (0-7)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($command);
}

//  Reply to Charge Completion Feedback Command

function replyToChargeCompletionFeedback($chargingPileAddress, $portNumber, $orderNumber, $amountUsed, $stopMode)
{
    $reply = [
        "pv" => 1,
        "fn" => "rptf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "ordernum",
                        "val" => $orderNumber // Order number
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "numMoney",
                        "val" => $amountUsed // Amount used (in minutes)
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "stopmode",
                        "val" => $stopMode // Stop mode value (0-7)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}

// Charging Power Report during Charging Process

function chargePowerReport($chargingPileAddress, $portNumber, $orderNumber, $currentPower, $currentTime)
{
    $report = [
        "pv" => 1,
        "fn" => "rpt",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "ordernum",
                        "val" => $orderNumber // Order number
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "chargepower",
                        "val" => $currentPower // Current charging power
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "powertime",
                        "val" => $currentTime // Current time
                    ]
                ]
            ]
        ]
    ];

    return json_encode($report);
}

// Coin Charging Completion Feedback Command

function coinChargeCompletionFeedback($chargingPileAddress, $portNumber, $orderNumber, $amountUsed, $startTime, $endTime, $coinCount, $stopMode)
{
    $command = [
        "pv" => 1,
        "fn" => "rpt",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "ordernum",
                        "val" => $orderNumber // Order number
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "numMoney",
                        "val" => $amountUsed // Amount used (in minutes)
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "starttime",
                        "val" => $startTime // Start time
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "endtime",
                        "val" => $endTime // End time
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "coincount",
                        "val" => $coinCount // Coin count
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "stopmode",
                        "val" => $stopMode // Stop mode value (0-7)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($command);
}


// Reply to Charge Coin Receive Command

function replyToChargeCoinReceive($chargingPileAddress, $portNumber, $orderNumber, $coinAmount, $amountUsed, $startTime, $endTime, $coinCount, $stopMode)
{
    $reply = [
        "pv" => 1,
        "fn" => "rptf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "ordernum",
                        "val" => $orderNumber // Order number
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "numCoin",
                        "val" => $coinAmount // Coin amount
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "numMoney",
                        "val" => $amountUsed // Amount used (in minutes)
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "starttime",
                        "val" => $startTime // Start time
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "endtime",
                        "val" => $endTime // End time
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "coincount",
                        "val" => $coinCount // Coin count
                    ],
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "stopmode",
                        "val" => $stopMode // Stop mode value (0-7)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}


// Query Port Status Command

function queryPortStatus($chargingPileAddress, $portNumber)
{
    $command = [
        "pv" => 1,
        "fn" => "rd",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "00000001",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "rl_portstate" // Read attributes port status
                    ]
                ]
            ]
        ]
    ];

    return json_encode($command);
}


// Reply to Port Status Query Command

function replyToPortStatusQuery($chargingPileAddress, $portNumber, $portStatus)
{
    $reply = [
        "pv" => 1,
        "fn" => "rdf",
        "ts" => 1000,
        "uid" => 0,
        "ck" => "00f7",
        "from" => "1",
        "pkg" => [
            [
                "to" => $chargingPileAddress,
                "data" => [
                    [
                        "type" => "BicycleCharger",
                        "oid" => $portNumber,
                        "p" => "rl_portstate", // Port status
                        "val" => $portStatus // Port status value (1, 2, 3, etc.)
                    ]
                ]
            ]
        ]
    ];

    return json_encode($reply);
}
