<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MachineService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Refill;
use App\Models\Transaction;
use App\Services\MqttService;
use App\Services\VendingMqttService;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    protected $paymentService;
    protected $vendingMqttService;
    protected $mqttservice;

    public function __construct(MqttService $mqttservice, VendingMqttService $vendingMqttService, PaymentService $paymentService)
    {
        $this->mqttservice = $mqttservice;
        $this->paymentService = $paymentService;
        $this->vendingMqttService = $vendingMqttService;
    }

    public function getMachine($id)
    {
        $machine = Machine::find($id)
        ->with(['machineType', 'products.category', 'refills.product'])
        ->first();

        return $machine
            ? successResponse('Machine fetched successfully.', $machine)
            : errorResponse('Machine fetch failed.');
    }

    public function cachePaymentResponse(Request $request)
    {
        $responseFromBkash = $this->mockBkashResponse($request->price);

        $status = $responseFromBkash['transactionStatus'];
        $amount = $responseFromBkash['amount'];

        // $responseFromBkash = $this->paymentService->bkashWebHook($request); // : change this in live

        // $isPaymentSuccess = $status === 'Completed' && $amount === (string) $request->price;

        // if(!$isPaymentSuccess) {
        //     return errorResponse('Payment failed.');
        // }

        $cacheDurationInMinute = 10;

        Cache::put('responseFromBkash', $responseFromBkash, $cacheDurationInMinute);

        return successResponse('cached payment data successfully.');
    }

    public function dispatchOrderAndSaveData(Request $request)
    {
        [$storeMachineTypeId, $boxMachineTypeId] = [1, 2];

        $isSuccess = false;

        $responseFromBkash = Cache::get('responseFromBkash');

        $transaction = $this->createTransactionData($request, $responseFromBkash);

        $isVendingType = $request->machine_type_id === $storeMachineTypeId || $request->machine_type_id === $boxMachineTypeId;

        $isSuccess = $isVendingType ? $this->dispatchFromMachine($request, $transaction->id) : $this->startMachine($request);

        if(!$isSuccess) {
            return errorResponse('Machine not responding, try again later.');
        }

        $isSaved = $this->saveRefillAndTransaction($request, $transaction);

        if(!$isSaved) {
            return errorResponse('Machine not responding, try again later.');
        }

        Cache::flush();

        $machine = Machine::find($request->machine_id)
            ->with(['machineType', 'products.category', 'refills.product'])
            ->first();

        return $machine
            ? successResponse('Dispatch successfully.', $machine)
            : errorResponse('Dispatch failed.');
    }

    private function saveRefillAndTransaction($request, $transaction)
    {
        $isRefillUpdated = $this->updateRefill($request);
        $isTransactionSaved = $this->saveTransaction($transaction);

        return $isRefillUpdated && $isTransactionSaved;
    }

    private function updateRefill($request)
    {

        $refill = Refill::where([
            ['machine_id', $request->machine_id],
            ['row_no', $request->row_no],
            ['column_no', $request->column_no]
        ])->first();

        if (!$refill) {
            return false;
        }

        $updatedQuantity = $refill->quantity - $request->quantity;

        if ($updatedQuantity < 0) {
            return false;
        }

        $refill->quantity = $updatedQuantity;
        $refill->save();
        return true;
    }

    private function saveTransaction($transaction)
    {
        return Transaction::create($transaction);
    }


    private function dispatchFromMachine($request, $transactionId)
    {
        return true; // just mocking successfull machine action


        $packetId = 1; // not sure what is the value , just dummy
        $response = $this->vendingMqttService->publishAndSubscribe($request, $transactionId, $packetId);

    }

    private function startMachine($request)
    {
        return true; // just mocking successfull machine action


        $orderNumber = 1;
        $amount = $request->total_amount;
        $topic = '/chargestub/order_send';
        $message = $this->mqttservice->sendOrder($orderNumber, $amount);
        $published = $this->mqttservice->publish($topic, $message);

        if ($published) {
            $topic = '/chargestub/order_recieve';
            $response = $this->mqttservice->subscribe($topic); // need to identify the status of machine whether success or not.
        }
    }

    // $responseFromBkash=null, $invoiceNo = null : should not be null in production
    private function createTransactionData($request, $responseFromBkash)
    {
        $dateTime = isset($responseFromBkash['dateTime']) ? $this->formatStringToDateTime($responseFromBkash['dateTime']) : null;

        return [
            'machine_id' => $request->machine_id,
            'product_id' => $request->product_id,
            'bkash_merchant_number' => $responseFromBkash['debitMSISDN'],
            'customer_number' => $responseFromBkash['creditShortCode'],
            'total_amount' => $responseFromBkash['amount'],
            'bkash_trx_id' => $responseFromBkash['trxID'],
            'invoice_no' => "invoice: " . $responseFromBkash['trxID'],
            'status' => $responseFromBkash['transactionStatus'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ];
    }

    private function formatStringToDateTime($string)
    {
        $dateTime = \DateTime::createFromFormat('YmdHis', $string);
        $formattedDateTime = $dateTime->format('Y-m-d H:i:s');

        return $formattedDateTime; // Output: '2018-04-19 12:22:46'
    }

    private function mockBkashResponse($price)
    {
        return [
            'dateTime' => '20230419122246',
            'creditShortCode' => '01815665965',
            'debitMSISDN' => '01856956542',
            'amount' => $price,
            'trxID' => 'trxid-12345',
            'transactionStatus' => 'Completed'
        ];
    }
}
