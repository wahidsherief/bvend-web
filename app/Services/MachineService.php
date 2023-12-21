<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\Lock;
use App\Models\Refill;
use App\Models\MachineType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use App\Services\BaseService;

class MachineService
{
    private $service;
    private $mqttservice;
    private $transactionService;

    protected $relations = [];
    protected $conditions = [];

    public function __construct(
        BaseService $service,
        MqttService $mqttservice,
        TransactionService $transactionService
    ) {
        $this->service = $service;
        $this->mqttservice = $mqttservice;
        $this->transactionService = $transactionService;
    }

    public function withRelations(array $relations)
    {
        $this->relations = $relations;
        return $this; // Return $this to allow chaining
    }

    public function withConditions(array $conditions)
    {
        $this->conditions = $conditions;
        return $this; // Return $this to allow chaining
    }

    public function all()
    {
        $allMachines = Machine::with($this->relations)->where($this->conditions)->get();
        return $this->transactionService->transactionsByMachines($allMachines);
    }

    public function get($id)
    {
        return Machine::with($this->relations)->find($id);
    }

    private function createMachineCode($typeId)
    {
        $machineType = MachineType::find($typeId)->name;
        $machineTypeFirstLetter = ucFirst(substr($machineType, 0, 1));
        $prefix = "B" . $machineTypeFirstLetter;
        $randomIdWithYear = rand(100, 999) . date("y");

        return $prefix . $randomIdWithYear;
    }

    private function processMachineData($request)
    {
        $code = $this->createMachineCode($request->machine_type_id);

        $isbKashQrExist = $request->hasFile('bkash_qr_code') && $request->file('bkash_qr_code')->isValid() && $request->file('bkash_qr_code')->isFile();

        if($isbKashQrExist) {

            $bKashQrCode = $request->file('bkash_qr_code');

            $storagePath = config('global.bkash_qr_code_image_path');

            $bKashQrCodeName = 'BKASH' . $code . '.' . $bKashQrCode->getClientOriginalExtension();

            $bKashQrCodePath = $storagePath . '/' . $bKashQrCodeName;

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            $bKashQrCode->move($storagePath, $bKashQrCodeName);

            $isQrCreated = file_exists($bKashQrCodePath);
        }

        return $updatedData = array_merge($request->all(), [
            'machine_code' => $code,
            'bkash_qr_code' => $bKashQrCodeName,
        ]);
    }

    public function save($request)
    {
        $data = $this->processMachineData($request);

        $machine = Machine::create($data);

        if(!$machine) {
            return false;
        }

        $isQrCodeUpdated = $this->updateWithQrCode($machine);

        if(!$isQrCodeUpdated) {
            Machine::find($machine->id)->delete();
            return false;
        }

        $isRefillCreated = $this->createRefills($machine, $request);

        if(!$isRefillCreated) {
            Machine::find($machine->id)->delete();
            return false;
        }

        // $isLocksCreated = $this->createMachineLocks($machine, $request);

        // if(!$isLocksCreated) {
        //     Refill::where('machine_id', $machine->id)->delete();
        //     Machine::find($machine->id)->delete();
        //     return errorResponse('Machine create failed');
        // }

        return $this->all();
    }

    public function update($request, $id)
    {
        if (isset($request->products)) {
            $products = json_decode($request->products);
            return $this->assignProduct($products, $id);
        }

        $isUpdated = Machine::find($id)->update($request->all());

        if (!$isUpdated) {
            return false;
        }

        return $this->all();
    }

    public function delete($id)
    {
        $machine = Machine::find($id);

        if ($machine && isset($machine->qr_code)) {

            $filePath = config('global.machine_qrcode_image_path') . $machine->qr_code;

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($machine && isset($machine->image)) {

            $this->service->deleteImage($machine->image);

            $filePath = config('global.machine_image_path') . $machine->qr_code;

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $isDeleted = $machine && $machine->delete() ? 1 : 0;

        if (!$isDeleted) {
            return false;
        }

        return $this->all();
    }

    public function toggleMachineActivation($machine_id, $attributes)
    {
        return Machine::where('id', $machine_id)->update($attributes);
    }

    private function assignProduct($products, $id)
    {
        $machine = Machine::find($id);

        foreach ($products as $product) {
            $machine->products()->attach($product);
        }

        return $this->all();

        // $machines = Machine::with($this->relations)->get();

        // return $machines ?
        //     successResponse('Product assigned successfully', $machines)
        //     : errorResponse('Machine assign failed');
    }

    private function createRefills($machine, $request)
    {
        $noOfRows = $request->no_of_rows;
        $noOfColumns = $request->no_of_columns;
        $refills = [];

        for ($i = 1; $i <= $noOfRows * $noOfColumns; $i++) {
            $row = ceil($i / $noOfColumns);
            $column = $i % $noOfColumns === 0 ? $noOfColumns : $i % $noOfColumns;

            $refills[] = [
                'machine_id' => $machine->id,
                'row_no' => $row,
                'column_no' => $column,
                'capacity' => $request->capacity,
                'quantity' => null,
                'price' => null
            ];
        }

        return Refill::insert($refills);

    }

    // private function createMachineLocks($machine, $request)
    // {
    //     $noOfRows = $request->no_of_rows;
    //     $noOfColumns = $request->no_of_columns;

    //     $totalLocks = $noOfRows * $noOfColumns;

    //     $locks = [];
    //     $lockCount = 0;

    //     for ($lock = 1; $lock <= $totalLocks; $lock++) {
    //         $row = ceil($lock / $noOfColumns);
    //         $column = $lock % $noOfColumns ?: $noOfColumns;

    //         $locks[$lockCount] = [
    //             'machine_id' => $machine->id,
    //             'row_no' => $row,
    //             'column_no' => $column,
    //             'refill_id' => null,
    //         ];

    //         $lockCount++;
    //     }

    //     return Lock::insert($locks);

    // }

    private function getMachineUrl($machineType, $id)
    {
        $machineTypeName = strtolower($machineType);
        return config('global.app_url') . '/' . $machineTypeName . '/' . $id;
    }

    private function updateWithQrCode($machine)
    {
        $storagePath = config('global.machine_qr_code_image_path');
        $machineTypeId = $machine->machineType->name;
        $machineUrlAsQrData = $this->getMachineUrl($machineTypeId, $machine->id);
        $machineCode = $machine->machine_code; // Extracting the machine code
        $qrFilename = $machineCode . '.png'; // Creating the desired filename
        $qrPath = $storagePath . '/' . $qrFilename;

        $qrImage = \QrCode::format('png')
            ->margin(0)
            ->size(500)
            ->generate($machineUrlAsQrData);

        // Ensure the folder exists before attempting to save the file
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        file_put_contents($qrPath, $qrImage);

        $isQrCreated = file_exists($qrPath);

        return $isQrCreated ? Machine::find($machine->id)->update(['qr_code' => $qrFilename]) : false;

    }

    /* Machine with MQTT functionalities */

    public function dispatchProducts(Request $request)
    {
        $params = $this->mqttservice->setParameters($request, '2');
        $published = $this->mqttservice->publish($params);

        if ($published) {
            $params = $this->mqttservice->setParameters($request, '3');
            echo $this->mqttservice->subscribe($params);
        }
    }

    public function updateMachineLockers($locks)
    {
        $all_locks = [];
        foreach ($locks as $lock) {
            // all locks in transaction
        }
        DB::table('locks')->where('machine_id', '')->update($all_locks);
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
