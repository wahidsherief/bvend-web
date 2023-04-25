<?php

namespace App\Http\Controllers;

use Mqtt;

class MqttController extends Controller
{
    public function PublishTopic()
    {
        $c = "3";
        $f = "1000001";
        $t = "861265732345497";
        $m = "6:00-24:00";
        $s = "EDAF8EB5D1DE1E5AF233EEF20BDDAB11";
        $k = "2";
        $e = md5($f+$t+$s+$m+$k);

        $topic = 'bvend/1000/1';
        
        
        $message = json_encode(["c" => $c,"f" => $f,"t" => $t,"m" => $m,"s" => $s, "e" => $e]);

        // $client_id = Auth::user()->id;
        $client_id = 1;
        $output = Mqtt::ConnectAndPublish($topic, $message, $client_id);

        if ($output === true) {
            var_dump($message);
            return 'Success \n';
        }
        
        return "Failed";
    }
    

    // public function SubscribetoTopic($topic)
    // {
    //     $mqtt = new Mqtt();
    //     // $client_id = Auth::user()->id;
    //     $mqtt->ConnectAndSubscribe($topic, function ($topic, $msg) {
    //         echo "Msg Received: \n";
    //         echo "Topic: {$topic}\n\n";
    //         echo "\t$msg\n\n";
    //     }, $client_id);
    // }
}
