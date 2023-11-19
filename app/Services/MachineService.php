<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\Lock;
use App\Models\MachineType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class MachineService
{
    protected $mqttservice;
    private $relations;

    public function __construct(MqttService $mqttservice)
    {
        $this->mqttservice = $mqttservice;
        $this->relations = [
            'machineType',
            'vendor',
            'productCategories'
        ];
    }

    public function all()
    {
        $machines = Machine::with($this->relations)->get() ?? 0;

        return $machines ? successResponse(null, $machines) : errorResponse();
    }

    public function get($id)
    {
        $machine = Machine::with($this->relations)->find($id);

        return $machine ? successResponse(null, $machine) : errorResponse();
    }

    public function save($request)
    {
        $code = 'b' . mt_rand(100000, 999999);

        $machineType = MachineType::find($request->machine_types_id)->type;

        $isQRcodeGenerated = $this->generateQRCode($code, $machineType);

        if(!$isQRcodeGenerated) {
            return errorResponse('QR code generation failed');
        }

        $machine = $this->createMachine($request);

        if(!$machine) {
            return errorResponse('Machine create failed');
        }

        $isLocksCreated = $this->createMachineLocks($machine, $request);

        if($isLocksCreated) {
            return successResponse(Machine::with($this->relations)->get());
        }

        Machine::find($machine->id)->delete();

        return errorResponse('Machine create failed');
    }

    public function update($request)
    {
        $attributes = $this->processUpdateInputs($request);

        $isUpdated = Machine::where('id', $request->machine_id)->update($attributes);

        return $isUpdated ? successResponse('Machine', Machine::find($request->machine_id)) : errorResponse();
    }

    public function delete($id)
    {
        $machine = Machine::find($id);

        $isDeleted = $machine !== null ? $machine->delete() : 0;

        if(!$isDeleted) {
            return errorResponse('Machine delete failed');
        }

        if ($machine->has('qr-code')) {
            $this->service->deleteImage($machine->file('qr-code'), 'machine');
        }

        if ($machine->has('image')) {
            $this->service->deleteImage($machine->file('image'), 'machine');
        }

        return successResponse(Machine::all());
    }

    public function toggleMachineActivation($machine_id, $attributes)
    {
        return Machine::where('id', $machine_id)->update($attributes);
    }

    private function processUpdateInputs($request)
    {
        $data = [];
        if (isset($request->address)) {
            $data['address'] = $request->address;
        }

        return $data;
    }

    private function createMachineLocks($machine, $request)
    {
        $noOfRows = $request->no_of_rows;
        $noOfColumns = $request->no_of_columns;
        $noOfLocksPerColumn = $request->locks_per_column;

        $totalLocks = $noOfRows * $noOfColumns * $noOfLocksPerColumn;

        $locks = [];
        $lockCount = 0;

        for ($lock = 1; $lock <= $totalLocks; $lock++) {
            $row = ceil($lock / ($noOfColumns * $noOfLocksPerColumn));
            $column = ceil(($lock % ($noOfColumns * $noOfLocksPerColumn)) / $noOfLocksPerColumn) ?: $noOfColumns;
            $lockNumber = $lock % $noOfLocksPerColumn ?: $noOfLocksPerColumn;

            $lockCode = $machine->machine_code . substr($machine->machineType->type, 0, 1) . $row . $column . $lockNumber;

            $locks[$lockCount] = [
                'machines_id' => $machine->id,
                'lock_code' => $lockCode,
                'row_number' => $row,
                'column_number' => $column,
                'lock_number' => $lockNumber,
                'refill_id' => 1,
            ];
            $lockCount++;
        }

        return Lock::insert($locks);
    }

    private function generateQRCode($machine_code, $type)
    {
        $storagePath = config('global.qrcode_image_path');
        $code = 'BVMC-' . $machine_code;
        $qr_code = $type . '-' . $machine_code . '.png';
        $imagePath = $storagePath . $qr_code;

        \QrCode::format('png')
            ->margin(0)
            ->size(500)
            ->generate($code, $imagePath);

        return File::exists($imagePath) ? true : false;
    }

    private function createMachine($request)
    {
        $data = $request->all();

        $machine = Machine::create($data);

        if ($request->categories) {
            foreach ($request->categories as $category) {
                $machine->productCategories()->attach($category);
            }
        }

        return $machine;
    }

    public function getAllMachinesOfVendor($vendor_id)
    {
        return Machine::where('vendor_id', $vendor_id)->with($this->relations)->get();
    }

    public function getSpecificMachineOfVendor($vendor_id, $machine_id)
    {
        return Machine::where(['id' => $machine_id, 'vendor_id' => $vendor_id])->with($this->relations)->first();
    }

    public function getProductsOfVendor($vendor_id)
    {
        $products = DB::table('products')
                    ->select('products.id', 'products.product_name')
                    ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                    ->join('vendor_product_categories', 'vendor_product_categories.product_category_id', '=', 'product_categories.id')
                    ->join('machines', 'vendor_product_categories.machine_id', '=', 'machines.id')
                    ->where('machines.vendor_id', '=', $vendor_id)
                    ->distinct()
                    ->get();

        return $products;
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
